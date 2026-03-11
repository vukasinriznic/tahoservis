<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequestStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'tachograph_type' => ['required', 'in:analogni,digitalni'],
            'description' => ['nullable', 'string'],
            'desired_date' => ['required'],
            'phone' => ['required', 'string'],
        ];
    }
}
