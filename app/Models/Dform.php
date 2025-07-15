<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dform extends Model
{
    use HasFactory;

    // In Dform model
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'dform_questions', 'dform_id', 'question_id');
    }

    // In Question model
    public function users()
    {
        return $this->belongsToMany(User::class, 'dform_user', 'dform_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

