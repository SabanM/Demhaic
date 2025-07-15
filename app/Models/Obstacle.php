<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obstacle extends Model
{
    use HasFactory;

    protected $fillable = ['obstacle', 'user_id', 'finished_at', 'description', 'position_x', 'position_y'];

    // Define relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
