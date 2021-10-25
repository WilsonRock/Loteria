<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NodeHasNodes extends Model
{
    use HasFactory;

    protected $fillable = ['padre_id', 'hijo_id'];
}
