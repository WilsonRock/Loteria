<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nodes extends Model
{
    use HasFactory;

    protected $fillable = ['type_node_id', 'active'];
}
