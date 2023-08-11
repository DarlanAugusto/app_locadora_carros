<?php

namespace App\Http\Controllers;

use App\Models\Marca;
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
        $marcas = array();

        // Campos do modelo
        if($request->has('modelo_fields')) {
            $marcas = $this->marca->with(["modelos:id,$request->modelo_fields"]);
        }
        else {
            $marcas = $this->marca->with(["modelos"]);
        }

        // Filtros where
        if($request->has('filter')) {
            $conditions = explode(';', $request->filter);

            foreach($conditions as $condition) {
                $where = explode(':', $condition);
                $marcas = $marcas->where($where[0], $where[1], $where[2]);
            }

        }

        // Campos da marca
        if($request->has('fields')) {
            $marcas = $marcas
                ->selectRaw($request->fields)
                ->get();

        } else {
            $marcas = $marcas->get();
        }

        return response()->json($marcas, 200);
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
