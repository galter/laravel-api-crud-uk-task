<?php

namespace Tests\Feature\V1;

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_update_his_account()
    {
        $bilbo = $this->bilbo();

        $this->actingAs($bilbo)
            ->json('PUT', "/api/v1/users/{$bilbo->id}", [
                'email' => 'frodo@baggins.uk',
                'givenName' => 'Frodo',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'email',
                    'givenName',
                    'familyName',
                ],
            ])
            ->assertJson([
                'data' => [
                    'id' => $bilbo->id,
                    'email' => 'frodo@baggins.uk',
                    'givenName' => 'Frodo',
                    'familyName' => 'Baggins',
                ]
            ])
            ->assertJsonCount(1);

        $bilbo->refresh();

        $this->assertEquals('frodo@baggins.uk', $bilbo->email);
        $this->assertEquals('Frodo', $bilbo->givenName);
    }

    /** @test */
    public function user_can_update_another_account()
    {
        $user = $this->user();
        $bilbo = $this->bilbo();

        $this->actingAs($bilbo)
            ->json('PUT', "/api/v1/users/{$user->id}", [
                'email' => 'Samwise@gamgee.uk',
                'givenName' => 'Samwise',
                'familyName' => 'Gamgee',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'email',
                    'givenName',
                    'familyName',
                ],
            ])
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'email' => 'Samwise@gamgee.uk',
                    'givenName' => 'Samwise',
                    'familyName' => 'Gamgee',
                ]
            ])
            ->assertJsonCount(1);
    }

    /** @test */
    public function user_can_update_his_password()
    {
        $bilbo = $this->bilbo();

        $this->actingAs($bilbo)
            ->json('PUT', "/api/v1/users/{$bilbo->id}", [
                'current_password' => '_my_pr3c10u5_',
                'password' => 'f3ll0w5h1p',
                'password_confirmation' => 'f3ll0w5h1p'
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'email',
                    'givenName',
                    'familyName',
                ],
            ])
            ->assertJson([
                'data' => [
                    'id' => $bilbo->id,
                    'email' => $bilbo->email,
                    'givenName' => $bilbo->givenName,
                    'familyName' => $bilbo->familyName,
                ]
            ])
            ->assertJsonCount(1);

        $this->assertTrue(Hash::check('f3ll0w5h1p', $bilbo->refresh()->password));
    }

    /** @test */
    public function user_cannot_update_his_password_without_current_password_and_password_confirmation()
    {
        $bilbo = $this->bilbo();

        $this->actingAs($bilbo)
            ->json('PUT', "/api/v1/users/{$bilbo->id}", [
                'password' => 'f3ll0w5h1p',
            ])
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'current_password',
                    'password',
                ],
            ])
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'current_password' => [
                        'The current password field is required when password is present.'
                    ],
                    'password' => [
                        'The password confirmation does not match.'
                    ],
                ]
            ]);

        $this->assertFalse(Hash::check('f3ll0w5h1p', $bilbo->refresh()->password));
    }

    /** @test */
    public function user_cannot_update_another_account()
    {
        $bilbo = $this->bilbo();
        $newUser = factory(User::class)->create();

        $this->json('PUT', "/api/v1/users/{$bilbo->id}", [
                'givenName' => 'Sam'
            ])
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    /** @test */
    public function user_can_delete_an_another_account()
    {
        $bilbo = $this->bilbo();
        $newUser = factory(User::class)->create();

        $this->actingAs($bilbo)
            ->json('DELETE', "/api/v1/users/{$newUser->id}")
            ->assertStatus(204);

        $this->assertDatabaseMissing('users', $newUser->toArray());
    }

    /** @test */
    public function user_cannot_delete_an_another_account()
    {
        $bilbo = $this->bilbo();
        $newUser = factory(User::class)->create();

        $this->json('DELETE', "/api/v1/users/{$bilbo->id}")
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }
}
