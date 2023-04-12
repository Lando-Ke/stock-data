<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'symbol',
        'security_name',
        'market_category',
        'financial_status',
        'test_issue',
        'round_lot_size',
    ];
}
