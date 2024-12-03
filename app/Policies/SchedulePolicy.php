<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SchedulePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Patient $patient): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        
        
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Schedule $schedule)
    {
        // Only the doctor who owns the schedule can update it
        return $user->id === $schedule->doctor->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Schedule $schedule)
    {
        // Only the doctor who owns the schedule can delete it
        return $user->id === $schedule->doctor->user_id; // Assuming Schedule has a relation to Doctor

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Patient $patient): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Patient $patient): bool
    {
        //
    }
}