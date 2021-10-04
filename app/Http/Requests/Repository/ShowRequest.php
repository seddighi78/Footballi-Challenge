<?php

namespace App\Http\Requests\Repository;

use App\Models\Repository;
use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    public function authorize()
    {
        /** @var Repository $repository */
        $repository = $this->route('repository');

        return $repository->user->id === auth('api')->id();
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
