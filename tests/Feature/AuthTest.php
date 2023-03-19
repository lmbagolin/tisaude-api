<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * @test
     */
    public function try_with_wrong_crendentials()
    {
        $credentials = [
            'email' => 'email-invalido',
            'password' => 'tisaude123'
        ];
        $response = $this->post('/api/auth/login', $credentials);
        $response->assertJsonStructure(['errors' => ['email']]);

        $credentials = [
            'email' => 'user@tisaude.com.br',
            'password' => ''
        ];
        $response = $this->post('/api/auth/login', $credentials);
        $response->assertJsonStructure(['errors' => ['password']]);
    }

    /**
     * @test
     */
    public function try_with_right_crendentials()
    {
        $credentials = [
            'email' => 'user@tisaude.com.br',
            'password' => 'tisaude123@'
        ];
        $response = $this->post('/api/auth/login', $credentials);
        $response->assertStatus(200);
    }
}
