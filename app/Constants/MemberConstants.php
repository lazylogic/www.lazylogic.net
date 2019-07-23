<?php

namespace App\Constants;

interface MemberConstants
{
    /*
     * Member Status
     */
    const MEM_STATUS_SECEDED = 'Z'; // 탈퇴 - 로그인 불가
    const MEM_STATUS_PAUSE   = 'P'; // 정지 - 로그인 불가
    const MEM_STATUS_DUPLE   = 'D'; // 중복 - 로그인 불가
    const MEM_STATUS_REGULAR = '1'; // 정상
    const MEM_STATUS_PENDING = '2'; // 미승인 선생님, 미성년 - 로그인 가능/결제 불가

    /*
     * Member Types
     */
    const MEM_TYPE_UNKNOWN   = '01'; //
    const MEM_TYPE_NONAGE    = '10'; // 어린이
    const MEM_TYPE_UNDERAGE  = '11'; // 미성년
    const MEM_TYPE_OVERAGE   = '12'; // 성인반
    const MEM_TYPE_PARENT    = '21'; // 학부모
    const MEM_TYPE_TEACHER   = '31'; // 선생님
    const MEM_TYPE_EVALUATOR = '41'; // 심사원   평가
    const MEM_TYPE_LECTURER  = '51'; // 온라인 강사

    const PATTERN_MEM_TYPE      = '/^(1.|2.|3.|4.|5.)$/'; // 모든 회원
    const PATTERN_MEM_NONAGE    = '/^(10)$/';             // 어린이
    const PATTERN_MEM_UNDERAGE  = '/^(11)$/';             // 미성년
    const PATTERN_MEM_CHILDREN  = '/^(10|11)$/';          // 자녀       : 어린이 + 미성년
    const PATTERN_MEM_STUDENT   = '/^(11|12)$/';          // 학생       : 미성년 + 성인반
    const PATTERN_MEM_OVERAGE   = '/^(12)$/';             // 성인반
    const PATTERN_MEM_LEARNER   = '/^(1.)$/';             // 수강생     : 어린이 + 미성년 + 성인반
    const PATTERN_MEM_PARENT    = '/^(2.)$/';             // 학부모
    const PATTERN_MEM_FAMILY    = '/^(10|11|2.)$/';       // 가족       : 어린이 + 미성년 + 학부모
    const PATTERN_MEM_CUSTOMER  = '/^(1.|2.)$/';          // 고객       : 어린이 + 미성년 + 성인반 + 학부모
    const PATTERN_MEM_TEACHER   = '/^(3.)$/';             //
    const PATTERN_MEM_EVALUATOR = '/^(4.)$/';             //
    const PATTERN_MEM_EDUCATOR  = '/^(3.|4.)$/';          //
    const PATTERN_MEM_ADULT     = '/^(12|2.|3.|4.)$/';    //
    const PATTERN_MEM_OPERATOR  = '/^(9[7-9])$/';         // ADMIN + MANAGER + OPERATOR
    const PATTERN_MEM_OFFICIAL  = '/^(9.)$/';             // ADMIN + MANAGER + OPERATOR + REPORTER + @
}