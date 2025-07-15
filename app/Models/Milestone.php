<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = ['milestone', 'user_id', 'finished_at', 'name', 'x_position', 'y_position'];

    // Define relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
