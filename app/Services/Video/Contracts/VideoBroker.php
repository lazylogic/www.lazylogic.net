<?php

namespace App\Services\Video\Contracts;

use App\Models\Video;

interface VideoBroker
{
    // TODO : public function upload( $video, $mem_pid, $options = [] );

    /**
     * Update video play progress
     *
     * @param   int     $video_pid
     * @param   int     $mem_pid
     *
     * @return  void
     */
    public function progress( $video_pid, $mem_pid, $options = [] );
}