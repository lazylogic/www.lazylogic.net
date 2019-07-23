<?php

namespace App\Constants;

interface ClassConstants
{
    const CODE_MAJOR   = 'M';
    const CODE_PACKAGE = 'P';
    const CODE_THEORY  = 'T';

    const CODE_ONEDAY  = 'S';
    const CODE_GLESSON = 'R';
    const CODE_ONLINE  = 'O';
    const CLASS_CODES  = [
        self::CODE_MAJOR   => '전공',
        self::CODE_PACKAGE => '전공+이론 패키지',
        self::CODE_THEORY  => '이론',
        self::CODE_ONEDAY  => 'One Day',
        self::CODE_GLESSON => 'Group Lesson',
        self::CODE_ONLINE  => 'Online Class',
    ];

    const TYPE_CLASS   = 'CLASS';
    const TYPE_ONEDAY  = 'ONEDAY';
    const TYPE_LESSON  = 'LESSON';
    const TYPE_GLESSON = 'GLESSON';
    const TYPE_OFFLINE = 'OFFLINE';
    const TYPE_ONLINE  = 'ONLINE';
    const CLASS_TYPES  = [
        self::TYPE_ONEDAY  => 'One Day',
        self::TYPE_LESSON  => '1:1 Lesson',
        self::TYPE_GLESSON => 'Group Lesson',
        self::TYPE_OFFLINE => 'Offline Lesson',
        self::TYPE_ONLINE  => 'Online Class',
    ];

    const GRADE_ALL       = TYPE_ALL;
    const GRADE_BASIC     = GRADE_BASIC;
    const GRADE_MASTER    = GRADE_MASTER;
    const GRADE_OPENTRACK = GRADE_OPENTRACK;
    const CLASS_GRADES    = [
        self::GRADE_MASTER => 'OpenTrack',
        self::GRADE_BASIC  => 'Basic Class',
    ];
}