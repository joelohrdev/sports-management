<?php

declare(strict_types=1);

use App\Models\Form;
use App\Models\Organization;

test('to array', function (): void {
    $form = Form::factory()->create()->refresh();

    expect(array_keys($form->toArray()))
        ->toBe([
            'id',
            'uuid',
            'organization_id',
            'name',
            'status',
            'schema',
            'price',
            'created_at',
            'updated_at',
        ]);
});

test('belongs to organization', function (): void {
    $organization = Organization::factory()->create();
    $form = Form::factory()->for($organization)->create();

    expect($form->organization->is($organization))->toBeTrue();
});
