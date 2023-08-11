<?php

namespace App\Http\Controllers;

use App\Models\Locacao;
use App\Repositories\LocacaoRepository;
use Illuminate\Http\Request;

class LocacaoController extends Controller
{
    private Locacao $locacao;

    public function __construct(Locacao $locacao)
    {
        $this->locacao = $locacao;
    }

    public function index(Request $request)
    {
        $locacaoRepository = new LocacaoRepository($this->locacao);
        $locacaoRepository->selectFieldsRelationship('cliente', $request->cliente_fields);
        $locacaoRepository->selectFieldsRelationship('carro', $request->carro_fields);
        $locacaoRepository->filter($request->filter);
        $locacaoRepository->selectFields($request->fields);

        return response()->json($locacaoRepository->getResults(), 200);
    }

    public function store(Request $request)
    {
        $request->validate($this->locacao->rules(), $this->locacao->feedbacks() );

        $locacao = Locacao::create($request->all());

        return response()->json($locacao, 201);
    }

    public function show($id)
    {
        $locacao = $this->locacao->with(['cliente', 'carro'])->find($id);

        if (!$locacao) {
            return response()->json(['error' => 'Recurso solicitado indisponível.'], 404);
        }

        return response()->json($locacao, 200);
    }

    public function update(Request $request, $id)
    {
        $locacao = $this->locacao->with(['cliente', 'carro'])->find($id);

        if(!$locacao) {
            return response()->json([
                'error' => 'Impossível realizar esta atualização. O recurso solicitado não existe.'
            ], 404);
        }

        if($request->method() == 'PATCH') {

            $regrasDinamicas= array();
            foreach($locacao->rules() as $field => $rules) {
                if(array_key_exists($field, $request->all())) {
                    $regrasDinamicas[ $field ] = $rules;
                }
            }

            $request->validate($regrasDinamicas, $locacao->feedbacks());
        }
        else {
            $request->validate($locacao->rules(), $locacao->feedbacks());
        }

        $locacao->update($request->all());

        return response()->json($locacao, 200);
    }

    public function destroy($id)
    {
        $locacao = $this->locacao->find($id);

        if(!$locacao) {
            return response()->json([
                'error' => 'Impossível realizar esta exclusão. O recurso solicitado não existe.'
            ], 404);
        }

        $locacao->delete();

        return response()->json([
            "message" => 'Locacao "' . $locacao->id . '" foi removido com sucesso!'
        ], 200);
    }
}
