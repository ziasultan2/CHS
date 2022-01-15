<?php

namespace Tests\Unit;

use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_registration()
    {
        $response = $this->post('api/register', [
            'name' => 'John Doe',
            'email' => 'ziasultan@gmail.com',
            'password' => '123456',
            'role' => 'admin'
        ]);
        $response->assertStatus(201);
    }

    public function test_login_successful()
    {
        $response = $this->post('api/login', [
            'email' => 'ziasultan@gmail.com',
            'password' => '123456',
        ]);
        $response->assertStatus(200);
    }

    public function test_login_unsuccessful()
    {
        $response = $this->post('api/login', [
            'email' => 'ziasultan@gmail.com',
            'password' => '123455',
        ]);
        $response->assertStatus(401);
    }
}
