<?php

namespace App\Livewire;

use App\Models\Media;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class MediaPicker extends Component
{
    use WithFileUploads;

    public $foto_baru;
    public string $statePath = '';

    public function mount(string $statePath = '')
    {
        $this->statePath = $statePath;
    }

    public function uploadFoto()
    {
        $this->validate([
            'foto_baru' => 'image|max:2048', // Maks 2MB
        ]);

        $namaAsli = $this->foto_baru->getClientOriginalName();
        $path = $this->foto_baru->storeAs(
            'invitations/user-' . Auth::id(),
            time() . '_' . $namaAsli,
            'public'
        );

        Media::create([
            'user_id' => Auth::id(),
            'file_name' => $namaAsli,
            'file_path' => $path,
            'file_hash' => md5_file($this->foto_baru->getRealPath()),
            'file_size' => round($this->foto_baru->getSize() / 1024, 2),
            'mime_type' => $this->foto_baru->getClientMimeType(),
        ]);

        $this->foto_baru = null;
    }

    public function render()
    {
        return view('livewire.media-picker', [
            'mediaItems' => Media::where('user_id', Auth::id())->latest()->get()
        ]);
    }
}
