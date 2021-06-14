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

    public function index(Request $request) {
        $ret = [];
        $qtde = $request->has('qtde');
        $de = $request->has('de');
        $users = Usuario::all();
        if ($de) $users = $users->skip($qtde)->get('*');
        if ($qtde) $users = $users->take($qtde)->get('*');

        foreach ($users as $user) {
            $ret[] = [
                'id' => $user->id,
                'nome' => $user->str_nome,
            ];
        }
        return Response($ret);
    }

    public function new(Request $request){
        $perfil = Usuario::where('str_cgc', $request->input('cgc'));
        if (!$perfil->exists())
            $perfil = $this->cadastroPerfil($request);

        $login = Login::where('str_login', $request->input('login'));
        if ($login->exists())
            return Response('{"codigo":3,"mesagem":"Login ja cadastrado"}',Response::HTTP_CONFLICT);

        $login = $this->cadastroLogin($request, $perfil->id);
        if ($login == null)
            return Response('{"codigo":3,"mesagem":"Nao foi possivel cadastrar"}',Response::HTTP_CONFLICT);

        return Response('criado',Response::HTTP_CREATED);
    }

    /**
     * Cadastro de um login
     *
     * @return void
     */
    private function cadastroLogin(Request $request, int $perfilId) {
        $login = new Login;
        $login->id = $perfilId;
        $login->str_login = $request->input('login');
        $login->str_senha = $request->input('senha');
        $login->save();
        return $login;
    }

    /**
     * Cadastro de um perfil
     *
     * @return Usuario
     */
    private function cadastroPerfil(Request $request) {

        $perfil = new Usuario;
        $perfil->str_nome    = $request->input('nome');
        $perfil->str_celular = $request->input('celular');
        $perfil->str_email   = $request->input('email');
        $perfil->str_genero  = $request->input('genero');
        $perfil->str_cgc     = $request->input('cgc');
        $perfil->str_tipo    = $request->input('tipo');
        $perfil->dat_nasc    = $request->input('nascimento');

        if (!$request->has('rua') && $request->input('rua') != null) {
            $endereco = Endereco::create([
                'str_cep'        => $request->input('cep'),
                'str_numero'     => $request->input('numero'),
                'str_logradouro' => $request->input('rua'),
                'str_bairro'     => $request->input('bairro'),
                'str_cidade'     => $request->input('cidade'),
                'str_estado'     => $request->input('estado'),
            ]);
            $perfil->endereco_id = $endereco->id;
        }

        $perfil->save();

        return $perfil;
    }

    public function perfil(int $id) {
        $user = Usuario::leftJoin('login', 'login.id', '=', 'usuarios.id')
            ->leftJoin('enderecos', 'enderecos.id', '=', 'usuarios.endereco_id')
            ->where('usuarios.id', $id)
            ->firstOrFail();
        $user->id = $id;
        return Response($user);
    }

    public function delete(int $id) {
        $usr = Usuario::find($id);
        if ($usr == null) return Response('{"codigo":3,"mesagem":"Nao Encontrado"}',Response::HTTP_NOT_FOUND);
        $usr->delete();
        return Response('',Response::HTTP_OK);
    }

    public function update(Request $request, int $id) {
        $usr = Usuario::find($id);
        if ($usr == null) return Response('{"codigo":3,"mesagem":"Nao Encontrado"}',Response::HTTP_NOT_FOUND);
        $lgn = Login::find($id);
        if ($lgn->str_senha    != $request->input('senha')) $lgn->str_senha     = $request->input('senha');
        if ($usr->str_celular  != $request->input('celular')) $usr->str_celular = $request->input('celular');
        if ($usr->str_nome     != $request->input('nome')) $usr->str_nome       = $request->input('nome');
        if ($usr->str_email    != $request->input('email')) $usr->str_email     = $request->input('email');
        if ($request->has('rua')){
            $endereco = Endereco::find($usr->endereco_id);
            $endereco->str_logradouro = $request->input('rua');
            if ($usr->str_cep    != $request->input('cep'))    $usr->str_cep    = $request->input('cep');
            if ($usr->str_numero != $request->input('numero')) $usr->str_numero = $request->input('numero');
            if ($usr->str_bairro != $request->input('bairro')) $usr->str_bairro = $request->input('bairro');
            if ($usr->str_cidade != $request->input('cidade')) $usr->str_cidade = $request->input('cidade');
            if ($usr->str_estado != $request->input('estado')) $usr->str_estado = $request->input('estado');
            $endereco->save();
        }
        $usr->save();
        $lgn->save();
        return Response('',Response::HTTP_OK);
    }
}
