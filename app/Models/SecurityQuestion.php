<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityQuestion extends Model
{
    use HasFactory;

        // Specify the table name if it's not the plural form of the model
        protected $table = 'security_questions';

        // Specify the primary key if it's not 'id'
        protected $primaryKey = 'qid'; // Adjust if your primary key is different
    
        // If you want to allow mass assignment, define the fillable attributes
        protected $fillable = [
            'id',       // Assuming you have an 'id' column
            'question', // Add other columns as necessary
        ];
}
