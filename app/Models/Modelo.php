<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    protected $fillable = [
        'marca_id',
        'nome',
        'imagem',
        'numero_portas',
        'lugares',
        'air_bag',
        'abs'
    ];

    public function rules()
    {
        return [
            'nome' => 'required|unique:App\Models\Modelo,nome,' . $this->id,
            'imagem' => 'required|file|mimes:png',
            'marca_id' => 'required|exists:App\Models\Marca,id',
            'numero_portas' => 'required|integer',
            'lugares' => 'required|integer',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean'
        ];
    }

    public function feedbacks()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'Esse modelo já existe',
            'imagem.file' => 'O campo :attribute deve ser um arquivo',
            'imagem.mimes' => 'O campo :attribute deve ser uma imagem do tipo PNG',
            'marca_id.exists' => 'A marca informada não existe.',
            'integer' => 'O campo :attribute deve ser um númro inteiro',
            'boolean' => 'O campo :attribute deve ser um booleano (true, false)'
        ];
    }

    public function marca()
    {
        return $this->belongsTo('App\Models\Marca', 'marca_id', 'id');
    }

    public function carros()
    {
        return $this->hasMany('App\Models\Carro', 'modelo_id', 'id');
    }
}
