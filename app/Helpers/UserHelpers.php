<?php

namespace App\Helpers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserHelpers extends TestCase
{
    public static function add_personal_team(User $user)
    {
        return Team::create([
            'user_id' => $user->id,
            'name' => "{$user->name}'s Team",
            'personal_team' => true,
        ]);
    }

    public static function create_regular_user()
    {
        $user = User::create([
            'name' => 'Regular',
            'email' => 'regular@videosapp.com',
            'password' => bcrypt('password'),
            'current_team_id' => null,
        ]);

        $team = self::add_personal_team($user);
        $user->update(['current_team_id' => $team->id]);

        return $user;
    }

    public static function create_video_manager_user()
    {
        $user = User::create([
            'name' => 'Video Manager',
            'email' => 'videosmanager@videosapp.com',
            'password' => bcrypt('password'),
            'current_team_id' => null,
        ]);

        $team = self::add_personal_team($user);
        $user->update(['current_team_id' => $team->id]);

        // Assignem el rol i permisos
        $videoManagerRole = Role::firstOrCreate(['name' => 'video_manager']);
        $user->assignRole($videoManagerRole);


        return $user;
    }

    public static function create_superadmin_user()
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@videosapp.com',
            'password' => bcrypt('password'),
            'super_admin' => true,
        ]);
        self::add_personal_team($user);

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $user->assignRole($superAdminRole);
        return $user;
    }

    public static function create_permissions()
    {
        Permission::firstOrCreate(['name' => 'manage-videos']);
        Permission::firstOrCreate(['name' => 'manage-users']);

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdminRole->givePermissionTo('manage-users');
    }
}
