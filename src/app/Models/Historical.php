<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historical extends Model
{
    use HasFactory;
    protected $table = 'historical_log';
    // protected $fillable = [
    //     'line_name',
    // ];
}
