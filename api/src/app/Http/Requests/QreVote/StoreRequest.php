<?php

declare(strict_types=1);

namespace App\Http\Requests\QreVote;

use App\Http\Requests\Traits\Castable;
use App\Http\Requests\Traits\CookieParameterToRequest;
use App\Http\Requests\Traits\SingleValidationMessage;
use Domain\Constant\User\UserToken;
use Illuminate\Foundation\Http\FormRequest;

/**
 * StoreRequest class
 */
final class StoreRequest extends FormRequest
{
    use Castable;
    use SingleValidationMessage;
    use CookieParameterToRequest;

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
            'user_token' => [
                'required',
                'min:' . UserToken::MAX_LENGTH,
            ],
            'questionnaireId' => [
                'required',
                'integer',
            ],
            'choiceId' => [
                'required',
                'integer',
            ],
        ];
    }
}
