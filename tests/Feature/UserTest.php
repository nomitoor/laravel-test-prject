<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Factories\UserFactory;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_get_list_of_users()
    {
        $user = UserFactory::times(2)->create();

        $response = $this->get('/api/users');

        $response->assertStatus(200);
        $response->assertSee($user->name);
    }
}
