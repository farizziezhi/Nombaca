<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'author'      => ['required', 'string', 'max:255'],
            'isbn'        => [
                'required',
                'string',
                'max:20',
                Rule::unique('books', 'isbn')->ignore($this->route('book')),
                'regex:/^[0-9\-]+$/',
            ],
            'stock'       => ['required', 'integer', 'min:0'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'isbn.unique' => 'ISBN ini sudah digunakan oleh buku lain.',
            'isbn.regex'  => 'ISBN hanya boleh berisi angka dan tanda hubung (-).',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'stock.min'   => 'Stok tidak boleh bernilai negatif.',
        ];
    }
}
