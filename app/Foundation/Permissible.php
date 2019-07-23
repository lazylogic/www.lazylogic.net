<?php

namespace App\Foundation;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

trait Permissible
{
    ///////////////////////////////////////////////////////////////////////////
    //
    //  Check Member Type
    //
    ///////////////////////////////////////////////////////////////////////////
    public static function permitLogin( $message = null )
    {
        return Auth::isLogin() or Response::unauthorized( $message ?: '로그인 후 이용해 주십시오.' );
    }

    public static function permitStudent( $message = null )
    {
        return Auth::isStudent() or Response::unauthorized( $message ?: '학생 회원만 이용할 수 있습니다.' );
    }

    public static function permitTeacher( $message = null )
    {
        return Auth::isTeacher() or Response::unauthorized( $message ?: '선생님 회원만 이용할 수 있습니다.' );
    }

    ///////////////////////////////////////////////////////////////////////////
    //
    //  Check Server Env
    //
    ///////////////////////////////////////////////////////////////////////////
    public static function allowEnv( $local = false, $devel = false, $test = false, $staging = false, $product = false )
    {
        static::allowLocal( $local );
        static::allowDevel( $devel );
        static::allowTest( $test );
        static::allowStaging( $staging );
        static::allowProduct( $product );
    }

    public static function allowLocal( $allow = true )
    {
        return App::environment( ENV_LOCAL ) ? ( $allow ? true : Response::unauthorized( ENV_LOCAL . ' Server 에서는 사용할 수 없습니다.' ) ) : ( $allow ? Response::unauthorized( ENV_LOCAL . ' Server 에서만 사용할 수 있습니다.' ) : true );
    }

    public static function allowDevel( $allow = true )
    {
        return App::environment( ENV_DEVEL ) ? ( $allow ? true : Response::unauthorized( ENV_DEVEL . ' Server 에서는 사용할 수 없습니다.' ) ) : ( $allow ? Response::unauthorized( ENV_DEVEL . ' Server 에서만 사용할 수 있습니다.' ) : true );
    }

    public static function allowTest( $allow = true )
    {
        return App::environment( ENV_TEST ) ? ( $allow ? true : Response::unauthorized( ENV_TEST . ' Server 에서는 사용할 수 없습니다.' ) ) : ( $allow ? Response::unauthorized( ENV_TEST . ' Server 에서만 사용할 수 있습니다.' ) : true );
    }

    public static function allowStaging( $allow = true )
    {
        return App::environment( ENV_STAGING ) ? ( $allow ? true : Response::unauthorized( ENV_STAGING . ' Server 에서는 사용할 수 없습니다.' ) ) : ( $allow ? Response::unauthorized( ENV_STAGING . ' Server 에서만 사용할 수 있습니다.' ) : true );
    }

    public static function allowProduct( $allow = true )
    {
        return App::environment( ENV_PRODUCT ) ? ( $allow ? true : Response::unauthorized( ENV_PRODUCT . ' Server 에서는 사용할 수 없습니다.' ) ) : ( $allow ? Response::unauthorized( ENV_PRODUCT . ' Server 에서만 사용할 수 있습니다.' ) : true );
    }
}