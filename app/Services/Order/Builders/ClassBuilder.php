<?php

namespace App\Services\Order\Builders;

use App\Foundation\Logging;
use App\Models\Clazz;
use App\Models\Order;
use App\Services\Order\Contracts\OrderBuilder;
use App\Services\Order\Exceptions;
use App\Services\Relation\Facades\RelationService;
use Illuminate\Support\Facades\Auth;

abstract class ClassBuilder implements OrderBuilder, \App\Constants\OrderConstants, \App\Constants\ClassConstants
{
    use Logging;

    protected $class;
    protected $mem_pid;
    protected $options;
    protected $order;

    public function __construct( Clazz $class, $mem_pid, $options = [] )
    {
        $this->class   = $class;
        $this->mem_pid = $mem_pid;
        $this->options = collect( $this->options )->merge( $options );
        $this->order   = new Order();
    }

    /**
     * Create New Order via Clazz
     *
     * @see  \App\Services\Order\Contracts\OrderBuilder
     */
    public function createOrder()
    {
        $this->arrangeMember();

        $this->arrangeOrder();

        $this->arrangeRoom();

        if ( ! $this->arrangeFree() ) {
            if ( ! $this->arrangeDiscount() ) {
                $this->arrangePrice();
            }
        }

        $this->order->save();
        return Order::detail( $this->order->pid() )->first();
    }

    /**
     * Arrange Member Info to Order
     *
     * @return  void
     */
    protected function arrangeMember()
    {
        $relation = RelationService::default( $this->mem_pid );

        if ( ! $relation->student_pid ) {
            throw new Exceptions\OrderException( __( 'phrase.need_child' ), HTTP_BAD_REQUEST );
        }

        $this->order->mem_pid         = $this->mem_pid;
        $this->order->student_mem_pid = optional( $relation )->student_pid;
        $this->order->parents_mem_pid = optional( $relation )->parent_pid;
        $this->order->parents_name    = optional( $relation )->parent_name;
        $this->order->parents_phone   = optional( $relation )->parent_phone;
    }

    /**
     * Arrange Clazz to Order
     *
     * @return  void
     */
    protected function arrangeOrder()
    {
        $this->order->product_type              = $this->class->product_type; // CLASS | ONEDAY | GLESSON
        $this->order->product_pid               = $this->class->class_pid;
        $this->order->teacher_mem_pid           = $this->class->teacher_pid;
        $this->order->teacher_course_lesson_pid = $this->class->teacher_course_lesson_pid; // 정기 그룹레슨일 경우 필요
        $this->order->pre_schedule_pid          = 0;
        $this->order->glesson_pid               = $this->class->class_pid;
        $this->order->course_title              = $this->class->class_title;
        $this->order->lesson_type               = $this->class->attributeValue( 'class_type' ); // S: 일일특강, R: 정기 그룹레슨, O: 온라인 Class
        $this->order->lesson_major              = $this->class->lesson_majors;
        $this->order->lesson_count              = $this->class->class_count;                                  // 주당 강의 수
        $this->order->lesson_total_count        = $this->class->class_count * $this->class->class_week_count; // 총 강의 수
        $this->order->lesson_days               = $this->class->class_week_count * 7;                         // 정기 그룹레슨 스케쥴 생성용. override in arrangeRoom()
        $this->order->lesson_time               = $this->class->class_time;                                   // 1강의 시간(H)
        $this->order->lesson_sday               = $this->class->class_sday;
        $this->order->lesson_eday               = $this->class->class_eday;
        $this->order->lesson_weeks              = $this->class->attributeValue( 'class_weeks' );
        $this->order->lesson_stimes             = $this->class->attributeValue( 'class_stimes' );
        $this->order->lesson_etimes             = $this->class->attributeValue( 'class_etimes' );
        $this->order->lesson_price_base         = $this->class->class_price; // 기본가격
        $this->order->lesson_price              = $this->class->order_price; // 할인 등 적용된 최종가격
        $this->order->discount_rate             = 0;                         // 선생님 레슨 할인율. Class 에서는 사용 안함
        $this->order->room_pids                 = $this->class->attributeValue( 'room_pids' );
        $this->order->room_price                = 0;
        $this->order->room_prices               = 0;
        $this->order->payment_price             = $this->class->order_price;
        $this->order->order_step                = self::STEP_INITIAL;
        $this->order->ip_addr                   = \Request::ip();
    }

    /**
     * Arrange Romm Price to Order
     *
     * - set lesson_days
     *
     * @return  void
     */
    abstract protected function arrangeRoom();

    /**
     * 무료 강의 이거나 무료 이벤트가 있는 경우
     * - 할인율 100%
     * - 결제 금액 0
     * - 결제 상태 : 완료 처리
     *
     * @return  bool    true: 무료처리 | false: 무료 처리 안함. 다음 단계( arrangeDiscount() )
     */
    protected function arrangeFree()
    {
        if ( $this->order->lesson_price_base == 0 || $this->options->is( 'event_type', TYPE_FREE ) ) {

            if ( $this->order->lesson_price_base == 0 ) {
                $pg_name = self::METHOD_FREE;
            } else if ( @$this->options['event_type'] == TYPE_FREE ) {
                $pg_name = self::METHOD_EVENT;
            } else {
                $pg_name = self::METHOD_CLESSON;
            }

            $this->order->payment_price = 0;                         // 실 결재 금액(PG사에 결제 요청금액). 무료
            $this->order->pg_name       = $pg_name;                  // 결재사(PG사) 명
            $this->order->pg_req_method = $pg_name;                  // PG사 결재 요청 수단
            $this->order->pg_req_dtime  = date( FORMAT_SQL_DATETIME ); // PG사 결재 요청 일시 (yyyymmddhhmiss)
            $this->order->pg_res_status = self::STATUS_SUCCESS;      // PG사 결재 승인 결과 (0000:결재성공)
            $this->order->pg_res_code   = self::STATUS_SUCCESS;      // PG사 결과 코드
            $this->order->pg_res_dtime  = date( FORMAT_SQL_DATETIME ); // PG사 결재 결과 일시 (yyyymmddhhmiss)
            $this->order->order_step    = self::STEP_FINISHED;       // 주문 단계 (99:PG사 결과 확인)

            return true;
        }
    }

    /**
     * 할인 설정이 되어 있거나, 할인 이벤트가 있는 경우
     *
     * @return  bool    true: 할인처리 | false: 할인 처리 안함. 다음 단계( arrangePrice() )
     */
    protected function arrangeDiscount()
    {
        if ( $this->options->is( 'event_type', TYPE_DISCOUNT ) ) {
            // TODO:
            return true;
        }
    }

    /**
     * Arrange Price to Order
     *
     * @param   \App\Models\Order   $this->order
     * @param   \App\Models\Clazz   $this->class
     * @param   array               $this->options
     *
     * @return  void
     */
    protected function arrangePrice()
    {
        $this->order->payment_price = $this->order->lesson_price - $this->order->room_price;
    }
}