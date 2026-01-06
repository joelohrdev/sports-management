<?php

use App\Models\Organization;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $name = '';
    #[Validate('nullable|string|max:255')]
    public string $primaryColor = '';
    #[Validate('nullable|image|max:1024')]
    public $logo;

    public function removePhoto(): void
    {
        $this->logo->delete();

        $this->logo = null;
    }

    public function save()
    {
        $org = Organization::create([
            'name' => $this->name,
            'primary_color' => $this->primaryColor,
            'owner_id' => auth()->id(),
        ]);

        $org->users()->attach(auth()->id());

        $logo = $this->logo->store($org->uuid, 'public');

        $org->update([
            'logo_path' => $logo,
        ]);

        Flux::toast(text: 'Organization created successfully', variant: 'success');

        return $this->redirect('dashboard', navigate: true);
    }
};
?>

<div>
    <form wire:submit.prevent="save" class="space-y-5">
        <flux:field>
            <flux:label badge="required">Organization Name</flux:label>
            <flux:input wire:model="name"/>
            <flux:error name="name"/>
        </flux:field>

        <flux:field>
            <flux:file-upload wire:model="logo" label="Upload files">
                <flux:file-upload.dropzone
                    heading="Drop files here or click to browse"
                    text="JPG, PNG, GIF up to 10MB"
                />
            </flux:file-upload>
            @if($logo)
                <div class="mt-4 flex flex-col gap-2">
                    <flux:file-item
                        :heading="$logo->getClientOriginalName()"
                        :image="$logo->temporaryUrl()"
                        :size="$logo->getSize()"
                    >
                        <x-slot name="actions">
                            <flux:file-item.remove wire:click="removePhoto"/>
                        </x-slot>
                    </flux:file-item>
                </div>
            @endif
            <flux:error name="logo"/>
        </flux:field>

        <flux:field>
            <flux:label>Organization Color</flux:label>
            <flux:input wire:model="primaryColor" type="color"/>
            <flux:error name="primaryColor"/>
        </flux:field>

        <flux:button type="submit" variant="primary">Submit</flux:button>
    </form>
</div>
