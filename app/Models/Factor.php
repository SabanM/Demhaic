<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description','example'];


    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
