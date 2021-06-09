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

    public function new(Request $request){
        if (DB::table('login')->where('str_login', '=', $request->login)->exists())
            return Response::HTTP_FOUND;
        dump($request->input('nome'));
        $perfil = $this->cadastroPerfil($request);
        $login = $this->cadastroLogin($request, $perfil->id);
        return Response::HTTP_CREATED;
    }

    /**
     * Cadastro de um login
     *
     * @return void
     */
    private function cadastroLogin(Request $request, int $perfilId) {
        $login = Login::create([
            'id' => $perfilId,
            'str_login' => $request->input('login'),
            'str_senha' => $request->input('senha'),
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
            'str_nome' => $request->input('nome'),
            'str_celular' => $request->input('celular'),
            'str_email' => $request->input('email'),
            'str_genero' => $request->input('genero'),
            'int_cgc' => $request->input('cgc'),
            'str_tipo' => $request->input('tipo'),
            'dat_nasc' => $request->input('nascimento'),
        ]);
        $endereco = Endereco::create([
            'str_cep' => $request->input('cep'),
            'str_numero' => $request->input('numero'),
            'str_logradouro' => $request->input('rua'),
            'str_bairro' => $request->input('bairro'),
            'str_cidade' => $request->input('cidade'),
            'str_estado' => $request->input('estado'),
        ]);
        $perfil->id_endereco = $endereco->id;
        $perfil->save();
        return $perfil;
    }

    public function perfil(int $id) {
        return Response(
            Usuario::find($id)
        );
    }

    public function delete(int $id) {
        $usr = Usuario::find($id);
        return Response::HTTP_OK;
    }
}
