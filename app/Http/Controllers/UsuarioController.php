<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Models\Login;
use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsuarioController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return Login
     */
    public function __construct()
    {
        //
    }

    public function index() {
        return Usuario::all();
    }

    public function new(Request $request, int $id = null){
        if (DB::table('login')->where('str_login', '=', $request->login)->exists())
            return Response::HTTP_FOUND;
        if ($id != null) {
            if (!DB::table()->where('id', $id)->exists())
                $perfil_id = $this->cadastroPerfil($request)->id;
        }
        $login = $this->cadastroLogin($request, $perfil_id);
        return Response::HTTP_CREATED;
    }

    /**
     * Cadastro de um login
     *
     * @return void
     */
    private function cadastroLogin(Request $request, int $id) {
        $login = Login::create([
            'id' => $id,
            'str_login' => $request->nome,
            'str_senha' => $request->nome,
            'id_usuario' => $request->nome,
        ]);
        return $login;
    }

    /**
     * Cadastro de um perfil
     *
     * @return Usuario
     */
    private function cadastroPerfil(Request $request) {
        $perfil = Usuario::create([
            'str_nome' => $request->nome,
            'str_celular' => $request->nome,
            'str_email' => $request->nome,
            'str_genero' => $request->nome,
            'int_cgc' => $request->nome,
            'str_tipo' => $request->nome,
            'dat_nasc' => $request->nome,
        ]);
        $endereco = Endereco::create([
            'str_cep' => $request->nome,
            'str_numero' => $request->nome,
            'str_logradouro' => $request->nome,
            'str_bairro' => $request->nome,
            'str_cidade' => $request->nome,
            'str_estado' => $request->nome,
            'str_cep' => $request->nome,
        ]);
        $perfil->id_endereco = $endereco->id;
        $perfil->save();
        return $perfil;
    }
}
