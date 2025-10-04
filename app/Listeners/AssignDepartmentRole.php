<?php

namespace App\Listeners;

use App\Models\Role;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User; // Import your specific User model

class AssignDepartmentRole
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        /** @var User $user */
        $user = $event->user;

        if ($user->role_id) {

            $role = Role::find($user->role_id);

            if ($role && !$user->hasRole($role->name)) {
                $user->syncRoles($role);
            }
        }
    }
}