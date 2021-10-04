<?php

namespace App\Http\Requests\Tag;

use App\Repository\RepositoryRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $repository_id
 * @property-read string $name
 */
class RemoveRequest extends FormRequest
{
    public function authorize(RepositoryRepositoryInterface $repositories)
    {
        $repository = $repositories->find($this->repository_id);

        if ($repository === null) {
            return false;
        }

        return $repository->user->id === auth('api')->id();
    }

    public function rules()
    {
        return [
            'repository_id' => ['required', 'int', 'exists:repositories,id'],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
