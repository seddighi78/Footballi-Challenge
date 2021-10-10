<?php

namespace App\Http\Requests\Repository;

use App\Repository\RepositoryRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    public function authorize(RepositoryRepositoryInterface $repositories)
    {
        $repository = $repositories->find($this->route('id'));

        if ($repository === null) {
            return false;
        }

        return $repository->user->id === auth('api')->id();
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
