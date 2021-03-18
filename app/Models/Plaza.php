<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plaza extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'municipio_id',
        'estado_id',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'municipio_id' => 'integer',
        'estado_id' => 'integer',
    ];


    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class);
    }

    public function municipio()
    {
        return $this->belongsTo(\App\Models\Municipio::class);
    }

    public function estado()
    {
        return $this->belongsTo(\App\Models\Estado::class);
    }
}
