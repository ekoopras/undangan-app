<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Wish;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function show($slug)
    {
        // Mengambil data undangan beserta ucapan-ucapan yang sudah masuk (diurutkan dari yang terbaru)
        $invitation = Invitation::with(['theme', 'wishes' => function ($query) {
            $query->latest();
        }])->where('slug', $slug)->firstOrFail();

        if (now()->greaterThan($invitation->active_until)) {
            abort(403, 'Masa aktif undangan ini telah habis.');
        }

        return view("themes.{$invitation->theme->code}", compact('invitation'));
    }

    public function storeWish(Request $request, $slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        // Validasi input dari tamu
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Simpan data ucapan baru dengan menyertakan invitation_id
        $wish = Wish::create([
            'invitation_id' => $invitation->id,
            'name' => $request->name,
            'message' => $request->message,
        ]);

        // Kembalikan respon dalam bentuk JSON agar halaman tidak perlu di-refresh (AJAX)
        return response()->json([
            'success' => true,
            'data' => [
                'name' => $wish->name,
                'message' => $wish->message,
                'time' => $wish->created_at->diffForHumans()
            ]
        ]);
    }
}
