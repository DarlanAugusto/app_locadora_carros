<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::all();

        return $marcas->toArray();
    }

    public function store(Request $request)
    {
        $marca = new Marca();
        $marca->nome = $request->get('nome');
        $marca->imagem = $request->get('imagem');
        $marca->save();

        return $marca->toArray();
    }

    public function show(Marca $marca)
    {
        return $marca->toArray();
    }

    public function update(Request $request, Marca $marca)
    {
        $marca->nome = $request->get('nome');
        $marca->imagem = $request->get('imagem');
        $marca->save();

        return $marca->toArray();
    }

    public function destroy(Marca $marca)
    {
        $marca->delete();

        return ["message" => 'Marca "' . $marca->nome . '" foi removida com sucesso!'];
    }
}
