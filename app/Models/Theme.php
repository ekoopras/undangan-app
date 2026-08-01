<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'title',
        'code'
    ];

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
