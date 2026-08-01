<div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
    <!-- Grid dipaksa kokoh 3 kolom di layar sedang/besar, dan otomatis ada scrollbar jika file banyak -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto p-1">
        @foreach($mediaFiles as $media)
        @php
        $url = \Illuminate\Support\Facades\Storage::url($media->file_path);
        @endphp
        <div
            @click="state = '{{ $media->file_path }}'"
            :class="state === '{{ $media->file_path }}' ? 'border-primary-600 ring-2 ring-primary-500 bg-primary-50/50 dark:bg-primary-950/20' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'"
            class="flex flex-col items-center p-2 border rounded-lg cursor-pointer hover:shadow-md transition-all duration-200 w-full">
            <!-- Area Preview Gambar -->
            <div class="w-full aspect-video overflow-hidden rounded-md bg-gray-100 dark:bg-gray-900 mb-2">
                <img src="{{ $url }}" alt="{{ $media->file_name }}" class="w-full h-full object-cover" />
            </div>

            <!-- Nama File dan Indikator Status Terpilih -->
            <div class="flex items-center justify-between w-full px-1 gap-2">
                <span class="text-[11px] text-gray-500 dark:text-gray-400 truncate flex-1">{{ $media->file_name }}</span>
                <div
                    :class="state === '{{ $media->file_path }}' ? 'bg-primary-600 border-primary-600' : 'border-gray-300 dark:border-gray-600'"
                    class="w-4 h-4 rounded-full border flex items-center justify-center flex-shrink-0">
                    <div x-show="state === '{{ $media->file_path }}' " class="w-1.5 h-1.5 bg-white rounded-full"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>