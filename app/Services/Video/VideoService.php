<?php

namespace App\Services\Video;

use App\Foundation\Logging;
use App\Models\Video;

class VideoService
{
    use Logging;

    /**
     * get Video
     *
     * @param   int     $video_pid
     *
     * @throws  \App\Services\Video\Exceptions\VideoNotFoundException
     *
     * @return  \App\Models\Video
     */
    public function video( $video_pid, $mem_pid = null )
    {
        if ( $video = Video::detail( $video_pid )->active()->first() ) {
            return $video;
        }

        throw new Exceptions\VideoNotFoundException( __( 'video.not_found_video' ), 400 );
    }

    /**
     * @see  \App\Services\Video\Contracts\VideoAgent
     */
    public function play( $video_pid, $mem_pid = null, $options = [] )
    {
        $video = $this->video( $video_pid, $mem_pid );

        // if ( $video->isExpired() ) { // 항상 isActivated 보다 먼저 체크
        //     throw new Exceptions\VideoStatusException( __( 'video.not_found_video' ), 400 );
        // }

        // if ( ! $video->isActivated() ) {
        //     throw new Exceptions\VideoStatusException( __( 'video.not_found_video' ), 400 );
        // }

        return VideoServiceFactory::agent( $video->host )->play( $video, $mem_pid, $options );
    }

    /**
     * @see  \App\Services\Video\Contracts\VideoAgent
     */
    public function auth( $video_pid, $mem_pid = null, $options = [] )
    {
        $video = $this->video( $video_pid, $mem_pid );

        if ( $video->isExpired() ) { // 항상 isActivated 보다 먼저 체크
            throw new Exceptions\VideoStatusException( __( 'video.not_found_video' ), 400 );
        }

        if ( ! $video->isActivated() ) {
            throw new Exceptions\VideoStatusException( __( 'video.not_found_video' ), 400 );
        }

        return VideoServiceFactory::agent( $video->host )->auth( $video, $mem_pid, $options );
    }

    /**
     * @see  \App\Services\Video\Contracts\VideoAgent
     */
    public function progress( $video_pid, $mem_pid = null, $options = [] )
    {
        return VideoServiceFactory::broker()->progress( $video_pid, $mem_pid, $options );
    }
}