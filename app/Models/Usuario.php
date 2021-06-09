<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
        'str_nome',
        'str_celular',
        'str_email',
        'str_genero',
        'int_cgc',
        'str_tipo',
        'dat_nasc',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'int_cgc'
    ];
}

