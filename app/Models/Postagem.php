<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postagem extends Model
{
    protected $fillable = [
        'str_coment',
        'usuario_id',
        'postagem_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];
}

