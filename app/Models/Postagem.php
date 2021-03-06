<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postagem extends Model
{
    protected $table = 'postagens';
    protected $primaryKey = 'id';
    protected $fillable = [
        'str_titulo',
        'str_texto',
        'usuario_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];
}

