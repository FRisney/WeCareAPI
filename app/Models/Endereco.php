<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{

    protected $fillable = [
        'str_cep',
        'str_numero',
        'str_logradouro',
        'str_bairro',
        'str_cidade',
        'str_estado',
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];
}

