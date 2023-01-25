<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    use HasFactory;
    protected $table = 'sku';
    protected $fillable = [
        'sku_name',
        'target',
        'th_H',
        'th_L'
    ];
}
