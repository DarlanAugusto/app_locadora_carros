<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    private Modelo $modelo;

    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;
    }

    public function index()
    {
        $modelos = $this->modelo->with(['marca'])->get();

        return response()->json($modelos, 200);
    }

    public function store(Request $request)
    {
        $request->validate($this->modelo->rules(), $this->modelo->feedbacks() );
        $path = $request->imagem->store('images/modelo', 'public');

        $modelo = Modelo::create([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $path,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);

        return response()->json($modelo, 201);
    }

    public function show($id)
    {
        $modelo = $this->modelo->with(['marca'])->find($id);

        if (!$modelo) {
            return response()->json(['error' => 'Recurso solicitado indisponível.'], 404);
        }

        return response()->json($modelo, 200);
    }

    public function update(Request $request, $id)
    {
        $modelo = $this->modelo->with(['marca'])->find($id);

        if(!$modelo) {
            return response()->json([
                'error' => 'Impossível realizar esta atualização. O recurso solicitado não existe.'
            ], 404);
        }

        if($request->method() == 'PATCH') {

            $regrasDinamicas= array();
            foreach($modelo->rules() as $field => $rules) {
                if(array_key_exists($field, $request->all())) {
                    $regrasDinamicas[ $field ] = $rules;
                }
            }

            $request->validate($regrasDinamicas, $modelo->feedbacks());
        }
        else {
            $request->validate($modelo->rules(), $modelo->feedbacks());
        }

        if(array_key_exists('imagem', $request->all())) {

            if($modelo->imagem) {
                Storage::disk('public')->delete($modelo->imagem);
            }

            $path = $request->imagem->store('images/modelo', 'public');
            $request = $request->all();
            $request['imagem'] = $path;
        }
        else {
            $request = $request->all();
        }

        $modelo->update($request);

        return response()->json($modelo, 200);
    }

    public function destroy($id)
    {
        $modelo = $this->modelo->find($id);

        if(!$modelo) {
            return response()->json([
                'error' => 'Impossível realizar esta exclusão. O recurso solicitado não existe.'
            ], 404);
        }

        if($modelo->imagem) {
            Storage::disk('public')->delete($modelo->imagem);
        }

        $modelo->delete();

        return response()->json([
            "message" => 'Modelo "' . $modelo->nome . '" foi removido com sucesso!'
        ], 200);
    }
}
