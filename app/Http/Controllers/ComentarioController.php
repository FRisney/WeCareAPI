<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Models\Projeto;
use App\Models\Postagem;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComentarioController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return Comentario
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request, int $post_id) {
        $ret = [];
        $qtde = $request->has('qtde');
        $de = $request->has('de');
        $coms = Comentario::where('postagem_id', $post_id)->get();
        if ($de) $coms = $coms->skip($qtde)->get('*');
        if ($qtde) $coms = $coms->take($qtde)->get('*');

        foreach ($coms as $com) {
            $ret[] = [
                'id' => $com->id,
                'relator' => Usuario::find($com->usuario_id)->str_nome,
                'titulo' => $com->str_titulo,
                'texto' => $com->str_coment,
                'data' => $com->created_at,
            ];
        }
        return Response($ret);
    }

    public function new(Request $request, int $post_id){
        $com = Comentario::create([
            'str_titulo' => $request->input('titulo'),
            'str_coment' => $request->input('texto'),
            'usuario_id' => $request->input('relator'),
            'postagem_id' => $post_id,
        ]);
        return Response($com,Response::HTTP_CREATED);
    }

    public function delete(int $post_id, int $comment_id) {
        $com = Comentario::where('id', $comment_id)->where('postagem_id', $post_id)->first();
        if ($com == null) return Response('{"codigo":3,"mesagem":"Nao Encontrado"}',Response::HTTP_NOT_FOUND);
        $com->delete();
        return Response('deleted',Response::HTTP_OK);
    }

    public function update(Request $request, int $post_id, int $comment_id) {
        $com = Comentario::where('id', $comment_id)->where('postagem_id', $post_id)->first();
        if ($com == null) return Response('{"codigo":3,"mesagem":"Nao Encontrado"}',Response::HTTP_NOT_FOUND);
        if ($com->str_titulo != $request->input('titulo')) $com->str_titulo = $request->input('titulo');
        if ($com->str_coment != $request->input('texto')) $com->str_coment = $request->input('texto');
        $com->save();
        return Response($com,Response::HTTP_OK);
    }
}
