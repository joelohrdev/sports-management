<?php

declare(strict_types=1);

use App\Models\Organization;
use App\Models\Season;
use App\Models\User;

test('to array', function (): void {
    $organization = Organization::factory()->create()->refresh();

    expect(array_keys($organization->toArray()))
        ->toBe([
            'id',
            'uuid',
            'user_id',
            'name',
            'slug',
            'owner_id',
            'logo_path',
            'primary_color',
            'created_at',
            'updated_at',
            'deleted_at',
        ]);
});

test('organization belongs to a user', function (): void {
    $user = User::factory()->create();
    $organization = Organization::factory()->for($user)->create();

    expect($organization->user->is($user))->toBeTrue();
});

test('organization has many seasons', function (): void {
    $organization = Organization::factory()->create();
    Season::factory()->count(3)->for($organization)->create();

    expect($organization->seasons)
        ->toHaveCount(3)
        ->each(fn ($season) => $season->organization_id->toBe($organization->id));
});
