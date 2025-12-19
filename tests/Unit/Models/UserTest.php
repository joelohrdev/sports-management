<?php

declare(strict_types=1);

use App\Models\Organization;
use App\Models\User;

test('to array', function (): void {
    $user = User::factory()->create()->refresh();

    expect(array_keys($user->toArray()))
        ->toBe([
            'id',
            'name',
            'email',
            'email_verified_at',
            'two_factor_confirmed_at',
            'created_at',
            'updated_at',
        ]);
});

test('user has many organizations', function (): void {
    $user = User::factory()->create();
    $organizations = Organization::factory()->count(3)->for($user)->create();

    expect($user->organizations)
        ->toHaveCount(3)
        ->each(fn ($organization) => $organization->user_id->toBe($user->id));
});
