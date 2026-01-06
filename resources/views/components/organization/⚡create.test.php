<?php

declare(strict_types=1);

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('organization.create')
        ->assertStatus(200);
});
