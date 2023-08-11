<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Repositories\CarroRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarroController extends Controller
{
    private Carro $carro;

    public function __construct(Carro $carro)
    {
        $this->carro = $carro;
    }

    public function index(Request $request)
    {
        $carroRepository = new CarroRepository($this->carro);
        $carroRepository->selectFieldsRelationship('modelo', $request->modelo_fields);
        $carroRepository->selectFieldsRelationship('locacoes', $request->locacao_fields);
        $carroRepository->filter($request->filter);
        $carroRepository->selectFields($request->fields);

        return response()->json($carroRepository->getResults(), 200);
    }

    public function store(Request $request)
    {
        $request->validate($this->carro->rules(), $this->carro->feedbacks() );

        $carro = Carro::create($request->all());

        return response()->json($carro, 201);
    }

    public function show($id)
    {
        $carro = $this->carro->with(['modelo', 'locacoes'])->find($id);

        if (!$carro) {
            return response()->json(['error' => 'Recurso solicitado indisponível.'], 404);
        }

        return response()->json($carro, 200);
    }

    public function update(Request $request, $id)
    {
        $carro = $this->carro->with(['modelo', 'locacoes'])->find($id);

        if(!$carro) {
            return response()->json([
                'error' => 'Impossível realizar esta atualização. O recurso solicitado não existe.'
            ], 404);
        }

        if($request->method() == 'PATCH') {

            $regrasDinamicas= array();
            foreach($carro->rules() as $field => $rules) {
                if(array_key_exists($field, $request->all())) {
                    $regrasDinamicas[ $field ] = $rules;
                }
            }

            $request->validate($regrasDinamicas, $carro->feedbacks());
        }
        else {
            $request->validate($carro->rules(), $carro->feedbacks());
        }

        $carro->update($request->all());

        return response()->json($carro, 200);
    }

    public function destroy($id)
    {
        $carro = $this->carro->find($id);

        if(!$carro) {
            return response()->json([
                'error' => 'Impossível realizar esta exclusão. O recurso solicitado não existe.'
            ], 404);
        }

        $carro->delete();

        return response()->json([
            "message" => 'Carro "' . $carro->placa . '" foi removido com sucesso!'
        ], 200);
    }
}
