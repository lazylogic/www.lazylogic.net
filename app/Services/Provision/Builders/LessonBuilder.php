<?php

namespace App\Services\Provision\Builders;

use App\Models\LessonReserve as Reserve;
use App\Models\LessonSchedule as Schedule;
use App\Models\Order;
use App\Services\Provision\Contracts\ProvisionBuilder;
use App\Services\Provision\Exceptions;

/**
 * Offline Class & Lesson Provision Builder
 */
class LessonBuilder extends BaseBuilder implements ProvisionBuilder, \App\Constants\OrderConstants, \App\Constants\LessonConstants
{
    public function createReserve()
    {
        try {

            $this->reserve = new Reserve();

            $this->arrangeReserve();

            \DB::transaction( function () {
                $this->reserve->save();
                $this->reserve->schedules()->saveMany( $this->arrangeSchedules() );
            } );

            return $this->reserve;

        } catch ( \Exception $e ) {
            throw new Exceptions\ProvisionException( $e );
        }
    }

    /**
     * Create Lesson Reseve via Order
     *
     * @return void
     */
    protected function arrangeReserve()
    {
        $this->reserve->order_lesson_pid          = $this->order->pid();
        $this->reserve->student_mem_pid           = $this->order->student_mem_pid;                             // 수강생(회원)의 고유 ID
        $this->reserve->parents_mem_pid           = $this->order->parents_mem_pid;                             // 수강생(부모회원)의 고유 ID
        $this->reserve->teacher_mem_pid           = $this->order->teacher_mem_pid;                             // 강사 고유 ID
        $this->reserve->teacher_course_lesson_pid = $this->order->teacher_course_lesson_pid;                   // 레슨 ID
        $this->reserve->lesson_type               = $this->order->lesson_type;                                 // 레슨타입 (M:전공,P:전공+이론패키지,T:이론)
        $this->reserve->course_title              = $this->order->course_title;                                // 코스 제목
        $this->reserve->lesson_days               = $this->order->lesson_days;                                 // 레슨 기간(단위 : 일, 1개월==4주==28일)
        $this->reserve->lesson_count              = $this->order->lesson_count;                                // 레슨 횟수(주1회~주7회)
        $this->reserve->lesson_remain_count       = $this->order->lesson_total_count;                          // 레슨 남은 횟수
        $this->reserve->lesson_total_count        = $this->order->lesson_total_count;                          // 레슨 총 횟수( 총 x 회)
        $this->reserve->lesson_room_pids          = $this->order->room_pids;                                   // 레슨실 고유 ID 1주에 여러장소일 경우 | 로 구분하여 사용
        $this->reserve->lesson_time               = $this->order->lesson_time;                                 // 레슨 시간(단위 : 분)
        $this->reserve->lesson_sday               = $this->order->lesson_sday;                                 // 레슨 시작 일(yyyymmdd)
        $this->reserve->lesson_eday               = $this->order->lesson_eday;                                 // 레슨 종료 일(yyyymmdd)
        $this->reserve->lesson_stimes             = $this->order->lesson_stimes;                               // 레슨 시작 시간(hhmiss) 1주에 여러요일 경우 | 로 구분하여 사용
        $this->reserve->lesson_etimes             = $this->order->lesson_etimes;                               // 레슨 종료 시간(hhmiss) 1주에 여러요일 경우 | 로 구분하여 사용
        $this->reserve->lesson_dayofweek          = $this->order->lesson_weeks;                                // 레슨 요일(0:일,1:월,2:화,3:수,4:목,5:금,6:토)1주에 여러요일 경우 | 로 구분하여 사용
        $this->reserve->lesson_status             = $this->options->get( 'lesson_status', self::STATUS_NORMAL ); // 주문 레슨 스케줄 등록 상태 (00:정상, 01:대기)
    }

    /**
     * Create Lesson Schedules
     *
     * @return array    array of \App\Models\LessonSchedule
     */
    protected function arrangeSchedules()
    {
        $day_of_weeks  = str_explode( $this->reserve->lesson_dayofweek );
        $room_pids     = str_explode( $this->reserve->lesson_room_pids );
        $room_prices   = str_explode( $this->order->room_prices );
        $lesson_stimes = str_explode( $this->reserve->lesson_stimes );
        $lesson_etimes = str_explode( $this->reserve->lesson_etimes );
        $settle_rate   = $this->settleRate();
        $schedules     = [];

        if ( $lessonDays = lesson_days( $this->reserve->lesson_sday, $this->reserve->lesson_days, $day_of_weeks ) ) {

            foreach ( $lessonDays as $idx => $lessonDay ) {

                $dowKey = day_of_week_key( $lessonDay, $day_of_weeks );

                $schedule                      = new Schedule();
                $schedule->mem_schedule_pid    = $this->reserve->pid();
                $schedule->student_mem_pid     = $this->reserve->student_mem_pid;
                $schedule->parents_mem_pid     = $this->reserve->parents_mem_pid;
                $schedule->teacher_mem_pid     = $this->reserve->teacher_mem_pid;
                $schedule->lesson_unit_no      = $idx + 1;
                $schedule->lesson_day          = $lessonDay;
                $schedule->day_of_week         = @$day_of_weeks[$dowKey];
                $schedule->lesson_stime        = @$lesson_stimes[$dowKey];
                $schedule->lesson_etime        = @$lesson_etimes[$dowKey];
                $schedule->room_pid            = @$room_pids[$dowKey];
                $schedule->room_amount         = (int) @$room_prices[$dowKey];
                $schedule->settle_rate         = $settle_rate;
                $schedule->settle_amount       = $this->settleAmount( $this->order->lesson_price, $this->order->lesson_total_count );
                $schedule->settle_real_amount  = $this->realAmount( $schedule->settle_amount, $settle_rate );
                $schedule->settle_final_amount = $this->finalAmount( $schedule->settle_real_amount, $schedule->room_amount );

                $schedules[] = $schedule;
            }
        }
        return $schedules;
    }

    /**
     * Lesson 기본 정상 수수료율. 20%
     *
     * @return  int
     */
    protected function settleRate()
    {
        return self::SETTLE_RATE_LESSON;
    }

    /**
     * 1회당 정산 금액(원단위 절사)
     *
     * @return  int
     */
    protected function settleAmount( $lesson_price, $lesson_total_count )
    {
        return floor( $lesson_price / $lesson_total_count / 10 ) * 10;
    }

    /**
     * 1회당 정산 금액에서 수수료 제외
     *
     * @return  int
     */
    protected function realAmount( $settle_amount, $settle_rate )
    {
        return floor( $settle_amount * ( 100 - $settle_rate ) / 1000 ) * 10;
    }

    /**
     * 최종 정산 금액 (실제정산 금액 + 대관비)
     *
     * @return  int
     */
    protected function finalAmount( $real_amount, $room_amount )
    {
        return $real_amount + $room_amount;
    }

}