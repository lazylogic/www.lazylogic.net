<?php
///////////////////////////////////////////////////////////////////////////////
//
// STATUS & Env
//
///////////////////////////////////////////////////////////////////////////////
/*
 * Serve Env
 */
defined( 'ENV_LOCAL' ) or define( 'ENV_LOCAL', 'local' );
defined( 'ENV_DEVEL' ) or define( 'ENV_DEVEL', 'devel' );
defined( 'ENV_TEST' ) or define( 'ENV_TEST', 'test' );
defined( 'ENV_STAGING' ) or define( 'ENV_STAGING', 'staging' );
defined( 'ENV_PRODUCT' ) or define( 'ENV_PRODUCT', 'production' );

/*
 * HTTP Status
 */
defined( 'HTTP_OK' ) or define( 'HTTP_OK', 200 );
defined( 'HTTP_MOVED_PERMANENTLY' ) or define( 'HTTP_MOVED_PERMANENTLY', 301 );
defined( 'HTTP_FOUND' ) or define( 'HTTP_FOUND', 302 );
defined( 'HTTP_BAD_REQUEST' ) or define( 'HTTP_BAD_REQUEST', 400 ); // default error
defined( 'HTTP_UNAUTHORIZED' ) or define( 'HTTP_UNAUTHORIZED', 401 );
defined( 'HTTP_NOT_FOUND' ) or define( 'HTTP_NOT_FOUND', 404 );
defined( 'HTTP_CONFLICT' ) or define( 'HTTP_CONFLICT', 409 );
defined( 'HTTP_PRECONDITION_FAILED' ) or define( 'HTTP_PRECONDITION_FAILED', 412 );     // request data error
defined( 'HTTP_INTERNAL_SERVER_ERROR' ) or define( 'HTTP_INTERNAL_SERVER_ERROR', 500 ); // server error

/*
 * Status
 */
defined( 'STATUS_INACTIVE' ) or define( 'STATUS_INACTIVE', 'INACTIVE' ); // 비활성
defined( 'STATUS_ACTIVE' ) or define( 'STATUS_ACTIVE', 'ACTIVE' );       // 활성
defined( 'STATUS_DISABLE' ) or define( 'STATUS_DISABLE', 'DISABLE' );    // 불가

defined( 'STATUS_INITIAL' ) or define( 'STATUS_INITIAL', 'INITIAL' );                // 초기
defined( 'STATUS_STARTED' ) or define( 'STATUS_STARTED', 'STARTED' );                // 시작
defined( 'STATUS_PARTICIPATED' ) or define( 'STATUS_PARTICIPATED', 'PARTICIPATED' ); // 참여
defined( 'STATUS_APPLIED' ) or define( 'STATUS_APPLIED', 'APPLIED' );                // 적용
defined( 'STATUS_CONFIRMED' ) or define( 'STATUS_CONFIRMED', 'CONFIRMED' );          // 확인
defined( 'STATUS_COMPLETED' ) or define( 'STATUS_COMPLETED', 'COMPLETED' );          // 완료
defined( 'STATUS_PURCHASABLE' ) or define( 'STATUS_PURCHASABLE', 'PURCHASABLE' );    // 구매가능
defined( 'STATUS_ONGOING' ) or define( 'STATUS_ONGOING', 'ONGOING' );                // 진행중
defined( 'STATUS_FINISHED' ) or define( 'STATUS_FINISHED', 'FINISHED' );             // 끝냄
defined( 'STATUS_ENDED' ) or define( 'STATUS_ENDED', 'ENDED' );                      // 종료
defined( 'STATUS_CLOSED' ) or define( 'STATUS_CLOSED', 'CLOSED' );                   // 마감
defined( 'STATUS_EXPIRED' ) or define( 'STATUS_EXPIRED', 'EXPIRED' );                // 만료

///////////////////////////////////////////////////////////////////////////////
//
// Type, Category, Grade, Trait, ...
//
///////////////////////////////////////////////////////////////////////////////
/*
 * Common Types
 */
defined( 'TYPE_ALL' ) or define( 'TYPE_ALL', 'ALL' );
defined( 'TYPE_FREE' ) or define( 'TYPE_FREE', 'FREE' );
defined( 'TYPE_DEFAULT' ) or define( 'TYPE_DEFAULT', 'DEFAULT' );

/* EOF : /config/constants.php */