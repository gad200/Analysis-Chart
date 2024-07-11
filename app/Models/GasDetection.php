<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GasDetection extends Model
{
    use HasFactory;
    protected $table = 'gase_detection';
    protected $fillable = ['gase', 'is_read'];
}
