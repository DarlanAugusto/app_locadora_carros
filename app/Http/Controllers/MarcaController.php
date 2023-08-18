<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Repositories\MarcaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    private Marca $marca;

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    public function index(Request $request)
    {
        $marcaRepository = new MarcaRepository($this->marca);
        $marcaRepository->selectFieldsRelationship('modelos', $request->modelo_fields);
        $marcaRepository->filter($request->filter);
        $marcaRepository->selectFields($request->fields);

        return response()->json($marcaRepository->getResultsPaginate(3), 200);
    }

    public function store(Request $request)
    {
        $request->validate($this->marca->rules(), $this->marca->feedbacks() );
        $path = $request->imagem->store('images/marca', 'public');

        $marca = Marca::create([
            'nome' => $request->nome,
            'imagem' => $path
        ]);

        return response()->json($marca, 201);
    }

    public function show($id)
    {
        $marca = $this->marca->with(['modelos'])->find($id);

        if (!$marca) {
            return response()->json(['error' => 'Recurso solicitado indisponível.'], 404);
        }

        return response()->json($marca, 200);
    }

    public function update(Request $request, $id)
    {
        $marca = $this->marca->with(['modelos'])->find($id);

        if(!$marca) {
            return response()->json([
                'error' => 'Impossível realizar esta atualização. O recurso solicitado não existe.'
            ], 404);
        }

        if($request->method() == 'PATCH') {

            $regrasDinamicas= array();
            foreach($marca->rules() as $field => $rules) {
                if(array_key_exists($field, $request->all())) {
                    $regrasDinamicas[ $field ] = $rules;
                }
            }

            $request->validate($regrasDinamicas, $marca->feedbacks());
        }
        else {
            $request->validate($marca->rules(), $marca->feedbacks());
        }

        if(array_key_exists('imagem', $request->all())) {

            if($marca->imagem) {
                Storage::disk('public')->delete($marca->imagem);
            }

            $path = $request->imagem->store('images/marca', 'public');
            $request = $request->all();
            $request['imagem'] = $path;
        }
        else {
            $request = $request->all();
        }

        $marca->update($request);

        return response()->json($marca, 200);
    }

    public function destroy($id)
    {
        $marca = $this->marca->find($id);

        if(!$marca) {
            return response()->json([
                'error' => 'Impossível realizar esta exclusão. O recurso solicitado não existe.'
            ], 404);
        }

        if($marca->imagem) {
            Storage::disk('public')->delete($marca->imagem);
        }

        $marca->delete();

        return response()->json([
            "message" => 'Marca "' . $marca->nome . '" foi removida com sucesso!'
        ], 200);
    }
}
