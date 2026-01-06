<x-layouts.app :title="__('Dashboard')">
    @if(!auth()->user()->organization())
        <div class="max-w-xl mx-auto">
            <livewire:organization.create />
        </div>
    @endif
</x-layouts.app>
