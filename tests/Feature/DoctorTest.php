<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DoctorTest extends TestCase
{
    public $access_token;


    /**
     * @test
     */
    public function verify_endpoints_response()
    {
        $credentials = [
            'email' => 'user@tisaude.com.br',
            'password' => 'tisaude123@'
        ];

        $response = $this->postJson('/api/auth/login', $credentials);
        $access_token = $response->original['access_token'];
        $header = ['Authorization' => 'Bearer ' . $access_token];

        $response = $this->get('/api/doctors', $header);
        $response->assertJsonStructure([
            'data',
            'links',
            'meta'
        ]);

        $response = $this->get('/api/doctors/1', $header);
        $response->assertJsonStructure([
            'doctor' => [
                'id',
                "name",
                "crm",
                "created_at",
                "updated_at",
                "deleted_at",
                "specialties"
            ]
        ]);
    }
}
