<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insight extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'daily_progress',
        'weekly_progress',
        'regression_tree',
        'factor_predictors',
        'chartsDataJson',
        'insight',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
