<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'company-symbol' => 'required|exists:companies,symbol',
            'start-date' => 'required|date|before_or_equal:end-date|before_or_equal:today',
            'end-date' => 'required|date|after_or_equal:start-date|before_or_equal:today',
            'email' => 'required|email',
        ];
    }
}
