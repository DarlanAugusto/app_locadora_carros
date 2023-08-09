<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    private Marca $marca;

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    public function index()
    {
        $marcas = $this->marca->all();

        return $marcas->toArray();
    }

    public function store(Request $request)
    {
        $marca = $this->marca;
        $marca->nome = $request->get('nome');
        $marca->imagem = $request->get('imagem');
        $marca->save();

        return $marca->toArray();
    }

    public function show($id)
    {
        $marca = $this->marca->find($id);

        return (!$marca) ? ['error' => 'Recurso solicitado indisponível.'] : $marca->toArray();
    }

    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);

        if(!$marca) return ['error' => 'Impossível realizar esta atualização. O recurso solicitado não existe.'];

        $marca->nome = $request->get('nome');
        $marca->imagem = $request->get('imagem');

        $marca->save();

        return $marca->toArray();
    }

    public function destroy($id)
    {
        $marca = $this->marca->find($id);

        if(!$marca) return ['error' => 'Impossível realizar esta remoção. O recurso solicitado não existe.'];

        $marca->delete();

        return ["message" => 'Marca "' . $marca->nome . '" foi removida com sucesso!'];
    }
}
