<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingTest extends TestCase
{
    protected $token;

    public function login()
    {
        $response = $this->post('api/login', [
            'email' => 'ziasultan_athlete@gmail.com',
            'password' => '123456',
        ]);
        $this->token = $response->json('access_token');
    }

    public function test_athlete_creation()
    {
        $response = $this->post('api/register', [
            'name' => 'John Doe',
            'email' => 'ziasultan_athlete@gmail.com',
            'password' => '123456',
            'role' => 'athlete'
        ]);
        $response->assertStatus(201);
    }

    public function test_booking_creation()
    {
        $this->login();
        $response = $this->post('api/bookings', [
            'package_id' => 1
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(302);
    }

    public function test_booking_index()
    {
        $this->login();
        $response = $this->get('api/bookings', [
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);
    }
}
