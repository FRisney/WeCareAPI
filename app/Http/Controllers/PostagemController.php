<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Models\Projeto;
use App\Models\Postagem;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostagemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return Postagem
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request) {
        $ret = [];
        $qtde = $request->has('qtde');
        $de = $request->has('de');
        $posts = Postagem::all();
        if ($de) $posts = $posts->skip($qtde)->get('*');
        if ($qtde) $posts = $posts->take($qtde)->get('*');

        foreach ($posts as $post) {
            $ret[] = [
                'id' => $post->id,
                'relator' => Usuario::find($post->usuario_id)->str_nome,
                'titulo' => $post->str_titulo,
                'data' => $post->created_at,
            ];
        }
        return Response($ret);
    }

    public function new(Request $request){
        $post = Postagem::create([
            'str_titulo' => $request->input('titulo'),
            'str_texto' => $request->input('texto'),
            'usuario_id' => $request->input('relator'),
        ]);
        return Response($post,Response::HTTP_CREATED);
    }

    public function detalhes(int $id) {
        $proj = Postagem::find($id);
        if ($proj == null) return Response('{"codigo":3,"mesagem":"Nao Encontrado"}',Response::HTTP_NOT_FOUND);
        return Response([
            'id' => $proj->id,
            'titulo' => $proj->str_titulo,
            'texto' => $proj->str_texto,
            'data' => $proj->created_at,
            'relator' => Usuario::find($proj->usuario_id)->str_nome,
        ]);
    }

    public function delete(int $id) {
        $proj = Postagem::find($id);
        if ($proj == null) return Response('{"codigo":3,"mesagem":"Nao Encontrado"}',Response::HTTP_NOT_FOUND);
        $coms = Comentario::where('postagem_id', $id)->get();
        if ($coms)
            foreach ($coms as $com){
                $com->delete();
            }
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
