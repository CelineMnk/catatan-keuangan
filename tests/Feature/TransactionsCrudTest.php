<?php

use App\Models\Transaction;
use App\Models\User;

it('can create, update and delete a transaction', function () {
    $user = User::factory()->create();

    // Create
    $postData = [
        'title' => 'Test Create',
        'description' => 'Created from test',
        'amount' => 500,
        'type' => 'income',
        'transaction_date' => now()->format('Y-m-d'),
    ];

    $response = $this->actingAs($user)->post(route('transactions.store'), $postData);
    $response->assertRedirect(route('transactions.index'));

    $this->assertDatabaseHas('transactions', [
        'user_id' => $user->id,
        'title' => 'Test Create',
    ]);

    $transaction = Transaction::where('user_id', $user->id)->where('title', 'Test Create')->first();
    expect($transaction)->not()->toBeNull();

    // Update
    $updateData = [
        'title' => 'Test Updated',
        'description' => 'Updated from test',
        'amount' => 750,
        'type' => 'expense',
        'transaction_date' => now()->format('Y-m-d'),
    ];

    $response = $this->actingAs($user)->put(route('transactions.update', $transaction), $updateData);
    $response->assertRedirect(route('transactions.index'));

    $this->assertDatabaseHas('transactions', [
        'id' => $transaction->id,
        'title' => 'Test Updated',
        'type' => 'expense',
    ]);

    // Delete
    $response = $this->actingAs($user)->delete(route('transactions.destroy', $transaction));
    $response->assertRedirect(route('transactions.index'));

    $this->assertDatabaseMissing('transactions', [
        'id' => $transaction->id,
    ]);
});
