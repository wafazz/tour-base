<x-filament-panels::page>
    {{-- Profile Form --}}
    <form wire:submit="save">
        {{ $this->form }}

        <div style="margin-top: 1.5rem;">
            <x-filament::button type="submit">
                Save Profile
            </x-filament::button>
        </div>
    </form>

    {{-- Document Upload --}}
    <div style="margin-top: 2rem;">
        <form wire:submit="uploadDocument">
            {{ $this->documentForm }}

            <div style="margin-top: 1.5rem;">
                <x-filament::button type="submit" color="info">
                    Upload Document
                </x-filament::button>
            </div>
        </form>
    </div>

    {{-- Existing Documents --}}
    @php $documents = $this->getDocuments(); @endphp
    @if($documents->count() > 0)
        <div style="margin-top: 2rem;">
            <x-filament::section>
                <x-slot name="heading">My Documents</x-slot>

                <div>
                    @foreach($documents as $doc)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 0; {{ !$loop->last ? 'border-bottom: 1px solid #e5e7eb;' : '' }}">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <x-filament::badge
                                    :color="match($doc->type) {
                                        'license' => 'primary',
                                        'passport' => 'info',
                                        'cert' => 'success',
                                        default => 'gray',
                                    }"
                                >
                                    {{ ucfirst($doc->type) }}
                                </x-filament::badge>
                                <a href="{{ Storage::disk('public')->url($doc->file_path) }}"
                                   target="_blank"
                                   style="font-size: 0.875rem; color: #D4A843; text-decoration: none;"
                                   onmouseover="this.style.textDecoration='underline'"
                                   onmouseout="this.style.textDecoration='none'">
                                    {{ $doc->original_name }}
                                </a>
                                @if($doc->verified_at)
                                    <x-filament::badge color="success" size="sm">Verified</x-filament::badge>
                                @else
                                    <x-filament::badge color="warning" size="sm">Pending Verification</x-filament::badge>
                                @endif
                            </div>
                            <x-filament::button
                                color="danger"
                                size="sm"
                                wire:click="deleteDocument({{ $doc->id }})"
                                wire:confirm="Are you sure you want to delete this document?"
                            >
                                Delete
                            </x-filament::button>
                        </div>
                    @endforeach
                </div>
            </x-filament::section>
        </div>
    @endif
</x-filament-panels::page>
