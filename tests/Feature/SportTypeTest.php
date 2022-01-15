<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SportTypeTest extends TestCase
{
    protected $token;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function login()
    {
        $response = $this->post('api/login', [
            'email' => 'ziasultan@gmail.com',
            'password' => '123456',
        ]);
        $this->token = $response->json('access_token');
    }

    public function test_sport_type_creation()
    {
        $this->login();
        $response = $this->post('api/sport-types', [
            'name' => 'Football',
            'description' => 'Football is a team sport played by two teams of eleven players with a spherical ball. The objective of the game is to score points by running the ball around the field under pressure from opposing teams. The team with the most points at the end of the game wins.',
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(201);
    }

    public function test_sport_index()
    {
        $this->login();
        $response = $this->get('api/sport-types', [
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);
    }

    public function test_sport_type_update()
    {
        $this->login();
        $response = $this->put('api/sport-types/1', [
            'name' => 'Football 2',
            'description' => 'Football is a team sport played by two teams of eleven players with a spherical ball. The objective of the game is to score points by running the ball around the field under pressure from opposing teams. The team with the most points at the end of the game wins.',
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);
    }

    public function test_sport_type_deletion()
    {
        $this->login();
        $response = $this->delete('api/sport-types/1', [], [
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(204);
    }
}
