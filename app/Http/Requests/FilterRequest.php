<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'ram'   => 'array|in:2,4,8,12,16,24,32,48,64,96',
            'ram.*' => 'integer',
        ];
    }
}
