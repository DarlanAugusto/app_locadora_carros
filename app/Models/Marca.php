<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'imagem'];

    public function rules() {
        return [
            'nome' => 'required|unique:App\Models\Marca,nome,' . $this->id,
            'imagem' => 'required'
        ];
    }

    public function feedbacks() {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'Essa marca já existe'
        ];
    }
}
