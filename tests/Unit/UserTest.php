<?php

namespace Tests\Unit;

use App\Models\User;
use App\Helpers\UserHelpers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_user_is_detected_correctly()
    {
        // Crear un usuari super-admin
        $superAdmin = UserHelpers::create_superadmin_user();

        // Verificar que l'usuari és super-admin utilitzant la funció isSuperAdmin()
        $this->assertTrue($superAdmin->isSuperAdmin());
    }
}
