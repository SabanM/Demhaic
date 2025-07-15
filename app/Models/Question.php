<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $casts = [
        'options' => 'array',  // Automatically casts options as an array when retrieved
    ];

        public function dforms()
    {
        return $this->belongsToMany(Dform::class, 'dform_questions', 'question_id', 'dform_id');
    }

    public function factors()
    {
        return $this->belongsToMany(Factor::class);
    }

    public function identifier()
    {
        return $this->belongsTo(Identifier::class);
    }
}
