<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Form Input Tamu --}}
        <form wire:submit="createLink" class="space-y-6">
            {{ $this->form }}

            <div class="flex justify-end w-full">
                <x-filament::button
                    type="submit"
                    icon="heroicon-m-plus-circle"
                    class="w-full sm:w-auto">
                    Generate Link
                </x-filament::button>
            </div>
        </form>

        {{-- Tabel / Card List Riwayat Link Tamu --}}
        <div>
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>