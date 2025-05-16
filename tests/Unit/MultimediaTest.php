<?php

namespace Tests\Feature;

use App\Models\Multimedia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Helpers\UserHelpers;

class MultimediaTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $user2;
    protected $file;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        // Crear usuari
        $this->user = UserHelpers::create_regular_user();
        $this->user2 = UserHelpers::create_video_manager_user();

        // Crear fitxer associat
        $this->file = Multimedia::create([
            'user_id' => $this->user->id,
            'filename' => 'fitxer.jpg',
            'display_name' => 'Original',
            'description' => 'Descripció original',
            'path' => 'uploads/fitxer.jpg',
            'type' => 'image',
            'size' => 1234,
        ]);

        // Simula que existeix l’arxiu
        Storage::disk('public')->put($this->file->path, 'fake content');
    }

    public function test_it_returns_all_multimedia_files()
    {
        $response = $this->actingAs($this->user)->getJson('/api/uploads');

        $response->assertOk()->assertJsonCount(1);
    }

    public function test_it_returns_authenticated_user_files_only()
    {
        $response = $this->actingAs($this->user)->getJson('/api/uploads/profile');
        $response->assertOk()
            ->assertJsonCount(1)
            ->assertJsonFragment(['display_name' => 'Original']);

        // Comprovar que un altre usuari no pot veure els fitxers de l'usuari original
        $responseForOtherUser = $this->actingAs($this->user2)->getJson('/api/uploads/profile');
        $responseForOtherUser->assertOk()
            ->assertJsonCount(0);
    }


    public function test_it_can_store_a_multimedia_file()
    {
        $imagePath = base_path('public/storage/rocket_racoon.jpg');

        $uploadedFile = new \Illuminate\Http\UploadedFile(
            $imagePath,
            'rocket_racoon.jpg',
            'image/jpeg',
            null,
            true
        );

        $response = $this->actingAs($this->user)->postJson('/api/uploads', [
            'file' => $uploadedFile,
            'name' => 'Rocker Raccon',
            'description' => 'Descripció nova',
        ]);

        $response->assertCreated()
            ->assertJsonFragment(['display_name' => 'Rocker Raccon']);

        Storage::disk('public')->assertExists('uploads/' . $uploadedFile->getClientOriginalName());
    }


    public function test_it_can_update_a_file()
    {
        $response = $this->actingAs($this->user)->putJson("/api/uploads/{$this->file->id}", [
            'display_name' => 'Actualitzat',
            'description' => 'Descripció nova',
        ]);

        $response->assertOk()
            ->assertJsonFragment(['display_name' => 'Actualitzat']);
    }

    public function test_it_can_delete_a_file()
    {
        $response = $this->actingAs($this->user)->deleteJson("/api/uploads/{$this->file->id}");

        $response->assertOk()
            ->assertJson(['message' => 'Arxiu esborrat correctament']);

        Storage::disk('public')->assertMissing($this->file->path);
    }
}
