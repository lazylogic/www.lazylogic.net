<?php

namespace App\Constants;

interface LessonConstants
{
    /**
     * member_schedule_master.lesson_status
     */
    const STATUS_NORMAL  = '00'; // 정상
    const STATUS_PENDING = '01'; // 대기

    /**
     * member_schedule_master.extend_status
     */
    const STATUS_INITIAL  = '0'; // 기본
    const STATUS_REQUEST  = '1'; // 연장 신청
    const STATUS_COMPLETE = '2'; // 연장 완료

}