<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SendLink extends Model
{
    protected $fillable = [
        'invitation_id',
        'recipient_name',
        'phone_number',
        'generated_url',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
