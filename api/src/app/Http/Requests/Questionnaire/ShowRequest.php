<?php

declare(strict_types=1);

namespace App\Http\Requests\Questionnaire;

use App\Http\Requests\Traits\RouteParameterToRequest;
use App\Http\Requests\Traits\SingleValidationMessage;
use Illuminate\Foundation\Http\FormRequest;

/**
 * ShowRequest class
 */
final class ShowRequest extends FormRequest
{
    use SingleValidationMessage;
    use RouteParameterToRequest;

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
            'questionnaireId' => [
                'required',
                'integer',
            ],
        ];
    }
}
