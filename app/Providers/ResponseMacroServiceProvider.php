<?php

namespace App\Providers;

use App\Foundation\Logging;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    use Logging;

    /**
     * Register the application's response macros.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Send JSON respons from Exceoption
         *
         * @param   \Exception  $e
         * @param   int         $code
         * @return  void
         */
        Response::macro( 'exception', function ( \Exception $e, $code = null ) {

            \App::environment( ENV_PRODUCT ) || report( $e );

            switch ( $code ?: $e->getCode() ) {
                case HTTP_UNAUTHORIZED:
                    return Response::unauthorized( $e->getMessage() );

                case HTTP_CONFLICT:
                    return Response::conflict( $e->getMessage() );

                case HTTP_INTERNAL_SERVER_ERROR:
                    return Response::serverError( $e->getMessage() );

                case HTTP_BAD_REQUEST:
                default:
                    return Response::badRequest( $e->getMessage() );
            }
        } );

        /**
         * Success
         *
         * @param   string  $message
         * @param   mixed   $data
         * @return  void
         */
        Response::macro( 'success', function ( $message = '', $data = [] ) {
            return Response::responseJson( 200, false, $message, $data );
        } );

        /**
         * 일반적인 요청 실패.
         * 서버가 이해할 수 없는 형식의 요청에 대한 응답.
         *
         * @param   string  $message
         * @param   mixed   $data
         * @return  void
         */
        Response::macro( 'badRequest', function ( $message = '', $data = [] ) {
            return Response::responseJson( 400, 'Bad Request', $message, $data );
        } );

        /**
         * 리소스 접근 권한이 없음.
         * 로그인이 필요한 경우.
         *
         * @param   string  $message
         * @param   mixed   $data
         * @return  void
         */
        Response::macro( 'unauthorized', function ( $message = '', $data = [] ) {
            return Response::responseJson( 401, 'Unauthorized', $message, $data );
        } );

        /**
         * 리소스 상태에 의하여 해당 요청을 수행 할 수 없음.
         * 이미 삭제된 리소스 삭제 등 리소스 상태에 의하여 해당 요청 자체를 수행할 수 없는 경우.
         *
         * @param   string  $message
         * @param   mixed   $data
         * @return  void
         */
        Response::macro( 'conflict', function ( $message = '', $data = [] ) {
            return Response::responseJson( 409, 'Conflict', $message, $data );
        } );

        /**
         * 일반적인 서버 에러.
         *
         * @param   string  $message
         * @param   mixed   $data
         * @return  void
         */
        Response::macro( 'serverError', function ( $message = '', $data = [] ) {
            return Response::responseJson( 500, 'Internal Server Error', $message, $data );
        } );

        /**
         * Create a new JSON response instance and send to client.
         *
         * @param   int     $code
         * @param   string  $error
         * @param   string  $message
         * @param   mixed   $data
         * @return  void
         */
        Response::macro( 'responseJson', function ( $code, $error, $message = '', $data = [] ) {
            $response['code']                          = $code;
            $error === false or $response['error']     = $error;
            $message === false or $response['message'] = $message;
            empty( $data ) or $response['data']          = $data;
            Response::json( $response, $code )->send();
            exit;
        } );

    }
}