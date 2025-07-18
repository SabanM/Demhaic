<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
     // Allow mass assignment for title and deadline
     protected $fillable = ['title', 'deadline','user_id'];
}
