<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{-- Render Form Filament --}}
        {{ $this->form }}

        {{-- Render Button Actions (Simpan Perubahan) --}}
        <div class="flex flex-col sm:flex-row justify-end w-full gap-2">
            @foreach ($this->getFormActions() as $action)
            {{ $action->extraAttributes(['class' => 'w-full sm:w-auto'], merge: true) }}
            @endforeach
        </div>
    </form>
</x-filament-panels::page>