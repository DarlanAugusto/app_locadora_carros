<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    public function rules()
    {
        return [
            'nome' => 'required|unique:App\Models\Cliente,nome,' . $this->id,
        ];
    }

    public function feedbacks()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'Esse nome já existe',
        ];
    }
}
