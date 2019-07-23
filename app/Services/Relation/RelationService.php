<?php

namespace App\Services\Relation;

use App\Foundation\Logging;
use App\Models\MemberRelation as Relation;
use Illuminate\Support\Facades\Auth;

class RelationService implements \App\Constants\RelationConstants
{
    use Logging;

    /**
     * @param   string  $to         phone number
     * @param   int     $mem_pid
     * @param   array   $options
     *
     * @return  \App\Models\MemberRelation
     */
    public function request( $to, $mem_pid, $options = [] )
    {
        //
    }

    /**
     * @param   int     $relation_pid
     * @param   int     $mem_pid
     * @param   array   $options
     *
     * @return  \App\Models\MemberRelation
     */
    public function retry( $relation_pid, $mem_pid, $options = [] )
    {
        //
    }

    /**
     * @param   int     $relation_pid
     * @param   int     $mem_pid
     * @param   array   $options
     *
     * @return  \App\Models\MemberRelation
     */
    public function cancel( $relation_pid, $mem_pid, $options = [] )
    {
        //
    }

    /**
     * @param   int     $relation_pid
     * @param   int     $mem_pid
     * @param   array   $options
     *
     * @return  \App\Models\MemberRelation
     */
    public function accept( $relation_pid, $mem_pid, $options = [] )
    {
        //
    }

    /**
     * @param   int     $relation_pid
     * @param   int     $mem_pid
     * @param   array   $options
     *
     * @return  \App\Models\MemberRelation
     */
    public function reject( $relation_pid, $mem_pid, $options = [] )
    {
        //
    }

    /**
     * @param   int     $relation_pid
     * @param   int     $mem_pid
     * @param   array   $options
     *
     * @return  \App\Models\MemberRelation
     */
    public function release( $mem_pid, $options = [] )
    {
        //
    }

    /**
     * @param   int     $mem_pid
     * @param   array   $options
     *
     * @return  \App\Models\MemberRelation
     */
    public function relations( $mem_pid, $options = [] )
    {
        //
    }

    /**
     * find default relation.
     *
     * @param   int     $mem_pid
     * @param   array   $options
     *
     * @return  \App\Models\MemberRelation
     */
    function default( $mem_pid, $options = [] ) {
        if ( ! ( $relation = Relation::relation( $mem_pid )->active()->first() ) ) {

            $relation = new Relation( ['student_pid' => 0, 'parent_pid' => 0] );

            if ( Auth::isStudent() ) {
                $relation->student_pid   = optional( Auth::user() )->mem_pid;
                $relation->student_name  = optional( Auth::user() )->mem_name;
                $relation->student_phone = optional( Auth::user() )->mem_phone;
            } else if ( Auth::isParent() ) {
                $relation->parent_pid   = optional( Auth::user() )->mem_pid;
                $relation->parent_name  = optional( Auth::user() )->mem_name;
                $relation->parent_phone = optional( Auth::user() )->mem_phone;
            }

        }
        return $relation;
    }

    public function chidren( $mem_pid, $options = [] )
    {
        //
    }

    public function parents( $mem_pid, $options = [] )
    {
        //
    }
}