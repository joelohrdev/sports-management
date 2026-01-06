@if(auth()->user()->organization()?->logo_path)
    <img class="h-8" src="{{ asset(auth()->user()->organization()->logo_path) }}" alt="{{ auth()->user()->organization()->name }}">
@endif
<div class="ms-1 grid flex-1 text-start text-sm">
    <span class="mb-0.5 truncate leading-tight font-semibold">{{ auth()->user()->organization() ? auth()->user()->organization()->name : 'Sports Management' }}</span>
</div>
