<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Models\Endereco;
use App\Models\Projeto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjetoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return Projeto
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request) {
        $ret = [];
        $qtde = $request->has('qtde');
        $de = $request->has('de');
        $projs = Projeto::all();
        if ($de) $projs = $projs->skip($qtde)->get('*');
        if ($qtde) $projs = $projs->take($qtde)->get('*');

        foreach ($projs as $proj) {
            $ret[] = [
                'id' => $proj->id,
                'nome' => $proj->str_nome,
            ];
        }
        return Response($ret);
    }

    public function new(Request $request){
        $projeto = Projeto::create([
            'str_nome' => $request->input('nome'),
            'str_desc' => $request->input('descricao'),
            'usuario_id' => $request->input('responsavel'),
        ]);
        return Response($projeto,Response::HTTP_CREATED);
    }

    public function detalhes(int $id) {
        $proj = Projeto::find($id);
        if ($proj == null) return Response('{"codigo":3,"mesagem":"Nao Encontrado"}',Response::HTTP_NOT_FOUND);
        $usr = Usuario::find($proj->usuario_id);
        if ($usr == null) return Response('{"codigo":3,"mesagem":"Nao Encontrado"}',Response::HTTP_NOT_FOUND);
        return Response([
            'id' => $proj->id,
            'nome' => $proj->str_nome,
            'descricao' => $proj->str_desc,
            'fundacao' => $proj->created_at,
            'responsavel' => $usr->nome,
            'email' => $usr->str_email,
            'celular' => $usr->str_celular,
        ]);
    }

    public function delete(int $id) {
        $proj = Projeto::find($id);
        if ($proj == null) return Response('{"codigo":3,"mesagem":"Nao Encontrado"}',Response::HTTP_NOT_FOUND);
        $proj->delete();
        return Response('',Response::HTTP_OK);
    }

    public function update(Request $request, int $id) {
        $prj = Projeto::find($id);
        if ($prj == null) return Response('{"codigo":3,"mesagem":"Nao Encontrado"}',Response::HTTP_NOT_FOUND);
        if ($prj->str_desc != $request->input('descricao')) $prj->str_desc = $request->input('descricao');
        if ($prj->str_nome != $request->input('nome')) $prj->str_nome = $request->input('nome');
        $prj->save();
        return Response('',Response::HTTP_OK);
    }
}
