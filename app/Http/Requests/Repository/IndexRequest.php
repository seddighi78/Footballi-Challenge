<?php

namespace App\Http\Requests\Repository;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $page
 * @property-read int $per_page
 * @property-read string $tag
 */
class IndexRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'tag' => ['sometimes', 'string'],
        ];
    }
}
