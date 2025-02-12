<?php

namespace Database\Seeders;

use App\Helpers\UserHelpers;
use App\Helpers\VideoHelpers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear rols i permisos
        $this->createRoles();

        // Crear usuaris per defecte
        $this->createDefaultUsers();

        VideoHelpers::createVideos();
    }

    private function createRoles(): void
    {
        // Definir permisos
        $permissions = [
            'manage_videos',
            'manage_users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear rols
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $videoManagerRole = Role::firstOrCreate(['name' => 'video-manager']);
        $regularUserRole = Role::firstOrCreate(['name' => 'regular-user']);

        // Assignar permisos als rols
        $superAdminRole->givePermissionTo(['manage_videos', 'manage_users']);
        $videoManagerRole->givePermissionTo(['manage_videos']);
        // El regular user no té permisos especials
    }


    private function createDefaultUsers(): void
    {
        // Crear els usuaris
        $superAdmin = UserHelpers::create_superadmin_user();
        $videoManager = UserHelpers::create_video_manager_user();
        $regularUser = UserHelpers::create_regular_user();

        // Assignar els rols als usuaris
        $superAdmin->assignRole('super-admin');
        $videoManager->assignRole('video-manager');
        $regularUser->assignRole('regular-user');
    }

}
