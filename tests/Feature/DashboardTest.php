<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create(['role' => 'customer']);
    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertRedirect('/customer/dashboard');
});

test('admin users are redirected to admin dashboard', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertRedirect('/admin');
});

test('craftsman users are redirected to craftsman dashboard', function () {
    $user = User::factory()->create(['role' => 'craftsman']);
    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertRedirect('/craftsman/dashboard');
});
