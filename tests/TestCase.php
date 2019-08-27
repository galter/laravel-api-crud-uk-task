<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $mockConsoleOutput = false;

    /**
     * Return an user with the anakin state
     * @return User
     */
    protected function bilbo($overrides = [])
    {
        return factory(User::class)->states('bilbo')->create($overrides);
    }

    /**
     * Return an user
     * @return User
     */
    protected function user($overrides = [])
    {
        return factory(User::class)->create($overrides);
    }

    /**
     * Acting as an user
     */
    protected function actingAsUser()
    {
        $this->actingAs($this->user());

        return $this;
    }
}
