<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Response;

trait RenderJson
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render( $request )
    {
        switch ( $this->code ) {
            case 401:
                return Response::unauthorized( $this->message );

            case 409:
                return Response::conflict( $this->message );

            case 500:
                return Response::serverError( $this->message );

            case 400:
            default:
                return Response::badRequest( $this->message );
        }
    }
}