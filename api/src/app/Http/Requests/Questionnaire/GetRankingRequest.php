<?php

declare(strict_types=1);

namespace App\Http\Requests\Questionnaire;

use App\Http\Requests\Traits\Castable;
use App\Http\Requests\Traits\SingleValidationMessage;
use Domain\Constant\Limit;
use Domain\Constant\Page;
use Illuminate\Foundation\Http\FormRequest;

/**
 * GetRankingRequest class
 */
final class GetRankingRequest extends FormRequest
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
            'case' => [
                'required',
                'string',
            ],
            'page' => [
                'required',
                'integer',
                'min:' . Page::MIN_LENGTH,
            ],
            'limit' => [
                'required',
                'integer',
                'min:' . Limit::MIN_LENGTH,
            ],
        ];
    }
}
