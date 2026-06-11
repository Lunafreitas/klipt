<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFotoRequest extends FormRequest
{
    public function authorize(): bool
    {
        $foto = $this->route('foto');

        return $foto && $this->user() && $foto->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'album_id' => [
                'required',
                Rule::exists('albums', 'id')->where('user_id', $this->user()->id),
            ],
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'imagem' => ['nullable', 'image', 'max:4096'],
            'publico' => ['required', 'boolean'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
        ];
    }
}
