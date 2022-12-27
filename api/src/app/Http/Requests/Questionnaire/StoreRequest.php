<?php

declare(strict_types=1);

namespace App\Http\Requests\Questionnaire;

use App\Http\Requests\Traits\Castable;
use App\Http\Requests\Traits\SingleValidationMessage;
use Domain\Constant\QreChoice\Body;
use Domain\Constant\QreChoice\DisplayOrder;
use Domain\Constant\Questionnaire\Description;
use Domain\Constant\Questionnaire\ThumbnailUrl;
use Domain\Constant\Questionnaire\Title;
use Domain\Constant\Tag\Name;
use Illuminate\Foundation\Http\FormRequest;

/**
 * StoreRequest class
 */
final class StoreRequest extends FormRequest
{
    use Castable, SingleValidationMessage;

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
            'userId' => [
                'required',
                'integer',
            ],
            'title' => [
                'required',
                'string',
                'max:' . Title::MAX_LENGTH,
            ],
            'description' => [
                'required',
                'string',
                'max:' . Description::MAX_LENGTH,
            ],
            'thumbnailUrl' => [
                'nullable',
                'string',
                'regex:' . ThumbnailUrl::VALID_PATTERN,
            ],
            'qreChoices' => [
                'required',
                'array',
            ],
            'qreChoices.*.body' => [
                'required',
                'string',
                'max:' . Body::MAX_LENGTH,
            ],
            'qreChoices.*.displayOrder' => [
                'required',
                'integer',
                'min:' . DisplayOrder::MIN_VALUE,
            ],
            'tags' => [
                'nullable',
                'array',
            ],
            'tags.*.id' => [
                'nullable',
                'integer',
            ],
            'tags.*.name' => [
                'nullable',
                'string',
                'max:' . Name::MAX_LENGTH,
            ],
        ];
    }
}
