<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;

    protected $fillable = [
        'modelo_id',
        'placa',
        'disponivel',
        'km'
    ];

    public function rules()
    {
        return [
            'modelo_id' => 'required|exists:modelos,id',
            'placa' => 'required|unique:App\Models\Carro,placa,' . $this->id,
            'disponivel' => 'required|boolean',
            'km' => 'required|numeric'
        ];
    }

    public function feedbacks()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'modelo_id.exists' => 'O modelo informada não existe.',
            'unique' => 'Esta placa já foi cadastrada em outro carro',
            'boolean' => 'O campo :attribute deve ser um booleano (true, false)',
            'numeric' => 'O campo :attribute deve ser um valor numérico'
        ];
    }

    public function modelo()
    {
        return $this->belongsTo('App\Models\Modelo', 'modelo_id', 'id');
    }

    public function locacoes()
    {
        return $this->hasMany('App\Models\Locacao', 'carro_id', 'id');
    }
}
