<?php

namespace App\Filament\App\Widgets;

use App\Models\Invitation;
use App\Models\SendLink;
use App\Models\Wish;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class InvitationStatsOverview extends BaseWidget
{
    // Mengatur agar widget refresh otomatis setiap beberapa detik (opsional)
    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        $userId = Auth::id();

        // 1. Ambil data undangan milik user yang login
        $invitations = Invitation::where('user_id', $userId)->get();

        // 2. Hitung Total Klik per Slug Undangan
        // Mengasumsikan ada kolom 'views_count' atau 'click_count' di tabel invitations
        // Jika tidak ada, fungsi sum() akan menghasilkan nilai total dari semua undangan milik user
        $totalClicks = $invitations->sum('click_count'); // Sesuaikan 'click_count' dengan nama kolom klik di database kamu

        // Rincian deskripsi per slug undangan
        $slugDetails = $invitations->map(function ($invitation) {
            $clicks = $invitation->click_count ?? 0;
            return "{$invitation->slug}: {$clicks} klik";
        })->implode(' | ');

        if (empty($slugDetails)) {
            $slugDetails = 'Belum ada undangan dibuat';
        }

        // 3. Hitung Jumlah Ucapan khusus untuk undangan milik user yang login
        $totalUcapan = Wish::whereHas('invitation', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();

        // 4. Hitung Jumlah SendLink (Tamu) khusus milik user yang login
        $totalSendLink = SendLink::whereHas('invitation', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();

        return [
            // Stat 1: Klik Link per Slug Undangan
            Stat::make('Jumlah Klik Link', number_format($totalClicks))
                ->description($slugDetails)
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->color('primary'),

            // Stat 2: Total Ucapan Masuk
            Stat::make('Jumlah Ucapan & Doa', number_format($totalUcapan))
                ->description('Total pesan ucapan dari tamu')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('success'),

            // Stat 3: Total Link Tamu (SendLink)
            Stat::make('Jumlah Link Generated (SendLink)', number_format($totalSendLink))
                ->description('Total penerima / target tamu')
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->color('warning'),
        ];
    }
}
