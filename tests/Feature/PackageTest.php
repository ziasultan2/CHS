<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PackageTest extends TestCase
{
    protected $token;
    public function login()
    {
        $response = $this->post('api/login', [
            'email' => 'ziasultan_coach@gmail.com',
            'password' => '123456',
        ]);
        $this->token = $response->json('access_token');
    }

    public function test_coach_creation()
    {
        $response = $this->post('api/register', [
            'name' => 'John Doe',
            'email' => 'ziasultan_coach@gmail.com',
            'password' => '123456',
            'role' => 'coach'
        ]);
        $response->assertStatus(201);
    }

    public function test_package_creation()
    {
        $this->login();
        $response = $this->post('api/packages', [
            'title' => 'Package 1',
            'description' => 'Football is a team sport played by two teams of eleven players with a spherical ball. The objective of the game is to score points by running the ball around the field under pressure from opposing teams. The team with the most points at the end of the game wins.',
            'price' => 11.99,
            'publish_date' => '2022-01-01',
            'session_time' => '01:00:00',
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(201);
    }

    public function test_package_index()
    {
        $this->login();
        $response = $this->get('api/packages', [
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);
    }

    public function test_package_update()
    {
        $this->login();
        $response = $this->put('api/packages/1', [
            'title' => 'Package 1',
            'description' => 'Football is a team sport played by two teams of eleven players with a spherical ball. The objective of the game is to score points by running the ball around the field under pressure from opposing teams. The team with the most points at the end of the game wins.',
            'price' => 11.99,
            'publish_date' => '2022-01-20',
            'session_time' => '04:00:00',    
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);
    }

    public function test_package_deletion()
    {
        $this->login();
        $response = $this->delete('api/packages/1', [], [
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(204);
    }
}
