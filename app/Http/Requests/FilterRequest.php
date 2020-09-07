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
            'storage' => 'array|in:0,250,1000,2000,3000,4000,8000,12000,24000,48000,72000',
            'storage.*' => 'integer',
            'ram' => 'array|in:2,4,8,12,16,24,32,48,64,96',
            'ram.*' => 'integer',
            'hard_disk_type' => 'string|in:ssd,sata,sas',
            'location' => 'string'
        ];
    }
}
