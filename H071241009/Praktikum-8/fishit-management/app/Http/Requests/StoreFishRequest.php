<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFishRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Izinkan semua orang
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'rarity' => ['required', Rule::in([
                'Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'
            ])],
            'base_weight_min' => 'required|numeric|min:0.01',
            // 'gt:base_weight_min' artinya nilainya harus > base_weight_min
            'base_weight_max' => 'required|numeric|gt:base_weight_min', 
            'sell_price_per_kg' => 'required|integer|min:1',
            // 'between:0.01,100.00' sesuai permintaan 0.01% - 100%
            'catch_probability' => 'required|numeric|between:0.01,100.00',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Pesan custom untuk validasi (Opsional tapi bagus)
     */
    public function messages(): array
    {
        return [
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum.',
            'catch_probability.between' => 'Peluang tangkap harus antara 0.01 dan 100.',
        ];
    }
}