<?php

if ( ! function_exists( 'sec_to_time' ) ) {

    function sec_to_time( $seconds, $format = 'H:i:s' )
    {
        return gmdate( $format, $seconds );
    }
}

if ( ! function_exists( 'datetime_diff' ) ) {

    function datetime_diff( $dateTime1, $dateTime2 )
    {
        return strtotime( $dateTime1 ) - strtotime( $dateTime2 );
    }
}

if ( ! function_exists( 'date_formater' ) ) {

    defined( 'PATTERN_DATE_YMD' ) or define( 'PATTERN_DATE_YMD', '$1-$2-$3' );
    defined( 'PATTERN_DATE_YMDHM' ) or define( 'PATTERN_DATE_YMDHM', '$1-$2-$3 $4:$5' );
    defined( 'PATTERN_DATE_YMDHMS' ) or define( 'PATTERN_DATE_YMDHMS', '$1-$2-$3 $4:$5:$6' );

    function date_formater( $time, $format = PATTERN_DATE_YMDHMS, $week = false, $pattern = '$1' )
    {
        return preg_replace( '/^(\d{4})(\d{2})(\d{2})(\d{2})?(\d{2})?(\d{2})?/', $format, $time ) . ( $week ? day_of_week( $time, $week, $pattern ) : '' );
    }
}

if ( ! function_exists( 'time_formater' ) ) {

    defined( 'PATTERN_TIME_HM' ) or define( 'PATTERN_TIME_HM', '$1:$2' );
    defined( 'PATTERN_TIME_HMS  ' ) or define( 'PATTERN_TIME_HMS', '$1:$2:$3' );

    function time_formater( $time, $format = PATTERN_TIME_HMS )
    {
        return preg_replace( '/^(\d{2})(\d{2})(\d{2})?/', $format, $time );
    }
}

if ( ! function_exists( 'str_to_date' ) ) {

    defined( 'FORMAT_DATETIME_EN' ) or define( 'FORMAT_DATETIME_EN', 'M j h:i A' );
    defined( 'FORMAT_DATETIME_KR' ) or define( 'FORMAT_DATETIME_KR', 'Y-m-d H:i' );

    function str_to_date( $time, $format = FORMAT_DATETIME_KR, $week = false, $pattern = '$1' )
    {
        return date( $format, strtotime( $time ) ) . ( $week ? day_of_week( $time, $week, $pattern ) : '' );
    }
}

if ( ! function_exists( 'day_of_week' ) ) {

    defined( 'DAY_OF_WEEK' ) or define( 'DAY_OF_WEEK', [
        'kr'  => ['일', '월', '화', '수', '목', '금', '토'],
        'kor' => ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
        'en'  => ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
        'eng' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
    ] );

    /**
     * 숫자 키, 요일문자로 부터 요일 구하기
     *
     * @param   string|int  $week
     * @param   string      $lang       ko | kor | en | eng
     * @param   string      $pattern    $1 | '... $1 ...'
     */
    function day_of_week( $week, $lang = 'kr', $pattern = '$1' )
    {
        $week = ( 0 <= $week && $week <= 6 ) ? $week : date( 'w', strtotime( $week ) );
        return str_replace( '$1', @DAY_OF_WEEK[$lang][$week], $pattern );
    }
}

///////////////////////////////////////////////////////////////////////////////
//
// Lesson Schdule
//
///////////////////////////////////////////////////////////////////////////////
if ( ! function_exists( 'lesson_days' ) ) {

    /**
     * 실제 수업 일자
     *
     * @param   int     $sdate  시작 일자. yyyymmdd
     * @param   int     $days   전체 레슨 기간(일). 7 배수
     * @param   array   $dows   수업 요일. ( 0:일, 1:월, 2:화, 3:수, 4:목, 5:금, 6:토 ) 1주에 여러요일 경우 '|' 로 구분
     *
     * @return  array|false
     */
    function lesson_days( $sdate, $days, array $dows )
    {
        $weeks = floor( $days / 7 ); // 총 몇 주
        $count = sizeof( $dows );    // 주당 수업 일 수

        if ( false === ( $sidx = day_of_week_key( $sdate, $dows ) ) ) { // 시작요일  인덱스
            return false;
        }

        $max          = $weeks * $count;
        $lessonDays[] = $sdate;
        for ( $i = 0; $i < $weeks; $i++ ) { // 총 주간 반복
            for ( $j = 0; $j < $count; $j++ ) { // 총 요일 반복
                if ( $max > sizeof( $lessonDays ) ) {
                    $didx         = ( $j + $sidx + 1 ) % $count; // 수업 요일($dows) 의 인덱스. 둘번째 요일 부터 시작
                    $widx         = $dows[$didx];              // 수업 요일 값. 0 ~ 6
                    $lessonDays[] = date( 'Ymd', strtotime( day_of_week( $widx, 'eng', 'next $1' ), strtotime( end( $lessonDays ) ) ) );
                } else {
                    break;
                }
            }
        }

        return $lessonDays;
    }
}

if ( ! function_exists( 'day_of_week_key' ) ) {

    /**
     * 날자로 신청 요일 중에서 Key 찾기
     *
     * @param   int     $date  yyyymmdd
     * @param   array   $dows   수업 요일. ( 0:일, 1:월, 2:화, 3:수, 4:목, 5:금, 6:토 ) 1주에 여러요일 경우 '|' 로 구분
     */
    function day_of_week_key( $date, array $dows )
    {
        return @array_search( date( 'w', strtotime( $date ) ), $dows );
    }
}

if ( ! function_exists( 'day_of_week_idx' ) ) {

    /**
     * 날자로 요일 번호 찾기
     *
     * @param   int             $date  yyyymmdd
     */
    function day_of_week_num( $date )
    {
        return date( 'w', strtotime( $date ) );
    }
}