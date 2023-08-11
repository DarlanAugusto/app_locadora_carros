<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locacao extends Model
{
    use HasFactory;

    protected $table = 'locacoes';
    protected $fillable = [
        'cliente_id',
        'carro_id',
        'data_inicio_periodo',
        'data_final_previsto_periodo',
        'data_final_realizado_periodo',
        'valor_diaria',
        'km_inicial',
        'km_final'
    ];

    public function rules()
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'carro_id' => 'required|exists:carros,id',
            'data_inicio_periodo' => 'required|date_format:Y-m-d H:i:s',
            'data_final_previsto_periodo' => 'required|date_format:Y-m-d H:i:s',
            'data_final_realizado_periodo' => 'required|date_format:Y-m-d H:i:s',
            'valor_diaria' => 'required|numeric',
            'km_inicial' => 'required|numeric',
            'km_final' => 'required|numeric'
        ];
    }

    public function feedbacks()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'exists' => 'O campo :attribute é inválido',
            'date_format' => 'O campo :attribute deve estar no formato Y-m-d H:i:s',
            'numeric' => 'O campo :attribute deve ser um valor numérico'
        ];
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'cliente_id', 'id');
    }

    public function carro()
    {
        return $this->belongsTo('App\Models\Carro', 'carro_id', 'id');
    }
}
