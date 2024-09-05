<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route('id'); 

        return [
            'name' => 'required|string|max:255',  
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|string|min:8',
            'type' => 'nullable|string',
            'bio' => 'nullable|string',
            'caminho_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de e-mail válido.',
            'email.unique' => 'O e-mail já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.string' => 'O campo senha deve ser uma string.',
            'password.min' => 'O campo senha deve ter pelo menos 8 caracteres.',
            'caminho_img.image' => 'O campo imagem deve ser uma imagem.',
            'caminho_img.mimes' => 'A imagem deve ser um arquivo do tipo: jpeg, png, jpg, gif.',
            'caminho_img.max' => 'A imagem não deve exceder 2 MB.',
        ];
    }
}
