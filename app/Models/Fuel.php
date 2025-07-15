<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    use HasFactory;

    protected $fillable = ['fuel', 'user_id', 'finished_at', 'description'];

    // Define relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
