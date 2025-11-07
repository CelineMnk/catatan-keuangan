<?php

use App\Models\Transaction;
use App\Models\User;

it('returns stats json for authenticated user', function () {
    // create user
    $user = User::factory()->create();

    // create some transactions across months
    $now = now();

    Transaction::create([
        'user_id' => $user->id,
        'title' => 'Salary',
        'description' => 'Monthly salary',
        'amount' => 3000,
        'type' => 'income',
        'transaction_date' => $now->copy()->subMonths(2)->format('Y-m-d'),
    ]);

    Transaction::create([
        'user_id' => $user->id,
        'title' => 'Groceries',
        'description' => 'Supermarket',
        'amount' => 250,
        'type' => 'expense',
        'transaction_date' => $now->copy()->subMonths(1)->format('Y-m-d'),
    ]);

    Transaction::create([
        'user_id' => $user->id,
        'title' => 'Freelance',
        'description' => 'Project payment',
        'amount' => 1200,
        'type' => 'income',
        'transaction_date' => $now->format('Y-m-d'),
    ]);

    // act as user and request stats data
    $response = $this->actingAs($user)->getJson(route('transactions.stats.data'));

    $response->assertStatus(200);

    $response->assertJsonStructure([
        '*' => ['date', 'income', 'expense', 'balance']
    ]);
});
