<?php

declare(strict_types=1);

namespace App\Http\Requests\Tag;

use App\Http\Requests\Traits\SingleValidationMessage;
use Domain\Constant\Tag\Name;
use Illuminate\Foundation\Http\FormRequest;

/**
 * StoreRequest class
 */
final class StoreRequest extends FormRequest
{
    use SingleValidationMessage;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:' . Name::MAX_LENGTH,
            ],
        ];
    }
}
