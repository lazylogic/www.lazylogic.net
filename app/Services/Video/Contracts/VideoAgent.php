<?php

namespace App\Services\Video\Contracts;

use App\Models\Video;

interface VideoAgent
{
    // TODO : public function upload( $video, $mem_pid, $options = [] );

    /**
     * Get Video Play Info.
     *
     * @param   \App\Models\Video|array $video
     * @param   int                     $mem_pid
     *
     * @return  mixed
     */
    public function play( $video, $mem_pid, $options = [] );

    /**
     * Authorize the user
     *
     * @param   \App\Models\Video   $video
     * @param   int                 $mem_pid
     *
     * @return  mixed
     */
    public function auth( Video $video, $mem_pid, $options = [] );

}