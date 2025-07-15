<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    public function dform()
    {
        return $this->belongsTo(Dform::class, 'dform_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
