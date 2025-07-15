<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecurityQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('security_questions')->insert([
            ['question' => 'What was the name of your first pet?'],
            ['question' => 'What is your mother’s maiden name?'],
            ['question' => 'What was the name of your first school?'],
            ['question' => 'What is your favorite food?'],
            ['question' => 'In what city were you born?'],
            ['question' => 'What was the make of your first car?'],
            ['question' => 'What is your favorite color?'],
            ['question' => 'What is the name of the street you grew up on?'],
            ['question' => 'What was your childhood nickname?'],
            ['question' => 'What is the name of your best friend from childhood?'],
            ['question' => 'What was the name of your first employer?'],
            ['question' => 'What was your first job title?'],
            ['question' => 'What is the name of your favorite teacher?'],
            ['question' => 'What is the name of the hospital where you were born?'],
            ['question' => 'What was the model of your first mobile phone?'],
            ['question' => 'What is your favorite book?'],
        ]);
    }
}
