<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Repositories\ClienteRepository;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    private Cliente $cliente;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    public function index(Request $request)
    {
        $clienteRepository = new ClienteRepository($this->cliente);
        $clienteRepository->selectFieldsRelationship('locacoes', $request->locacao_fields);
        $clienteRepository->filter($request->filter);
        $clienteRepository->selectFields($request->fields);

        return response()->json($clienteRepository->getResults(), 200);
    }

    public function store(Request $request)
    {
        $request->validate($this->cliente->rules(), $this->cliente->feedbacks() );

        $cliente = Cliente::create($request->all());

        return response()->json($cliente, 201);
    }

    public function show($id)
    {
        $cliente = $this->cliente->with(['locacoes'])->find($id);

        if (!$cliente) {
            return response()->json(['error' => 'Recurso solicitado indisponível.'], 404);
        }

        return response()->json($cliente, 200);
    }

    public function update(Request $request, $id)
    {
        $cliente = $this->cliente->with(['locacoes'])->find($id);

        if(!$cliente) {
            return response()->json([
                'error' => 'Impossível realizar esta atualização. O recurso solicitado não existe.'
            ], 404);
        }

        if($request->method() == 'PATCH') {

            $regrasDinamicas= array();
            foreach($cliente->rules() as $field => $rules) {
                if(array_key_exists($field, $request->all())) {
                    $regrasDinamicas[ $field ] = $rules;
                }
            }

            $request->validate($regrasDinamicas, $cliente->feedbacks());
        }
        else {
            $request->validate($cliente->rules(), $cliente->feedbacks());
        }

        $cliente->update($request->all());

        return response()->json($cliente, 200);
    }

    public function destroy($id)
    {
        $cliente = $this->cliente->find($id);

        if(!$cliente) {
            return response()->json([
                'error' => 'Impossível realizar esta exclusão. O recurso solicitado não existe.'
            ], 404);
        }

        $cliente->delete();

        return response()->json([
            "message" => 'Cliente "' . $cliente->nome . '" foi removido com sucesso!'
        ], 200);
    }
}
