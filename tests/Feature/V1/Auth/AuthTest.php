<?php

namespace Tests\Feature\V1\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_retrieve_a_jwt()
    {
        $this->bilbo();

        $this->json('POST', '/api/v1/auth/login', [
                'email' => 'bilbo@baggins.uk',
                'password' => '_my_pr3c10u5_'
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
                'user_id',
            ])
            ->assertJson([
                'token_type' => 'bearer',
                'expires_in' => 172800
            ]);
    }

    /** @test */
    public function user_cannot_retrieve_a_jwt()
    {
        $this->json('POST', '/api/v1/auth/login', [
                'email' => 'bilbo@baggins.uk',
                'password' => '_my_pr3c'
            ])
            ->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'email' => ['These credentials do not match our records.']
                ]
            ]);
    }

    /** @test */
    public function user_can_be_authenticated_with_jwt()
    {
        $bilbo = $this->bilbo();
        $bilbo->wasRecentlyCreated = false;

        $this->actingAs($bilbo)
            ->json('GET', '/api/v1/auth/me')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'email',
                    'givenName',
                    'familyName',
                ]
            ])
            ->assertJson([
                'data' => [
                    'email' => 'bilbo@baggins.uk',
                    'givenName' => 'Bilbo',
                    'familyName' => 'Baggins',
                ]
            ]);
    }

    /** @test */
    public function user_must_be_authenticated()
    {
        $this->json('GET', '/api/v1/auth/me')
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }
}
