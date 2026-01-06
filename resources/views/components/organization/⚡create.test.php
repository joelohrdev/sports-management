<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('organization.create')
        ->assertStatus(200);
});
