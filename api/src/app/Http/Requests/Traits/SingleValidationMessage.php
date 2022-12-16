<?php

declare(strict_types=1);

namespace App\Http\Requests\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as StatusCode;

trait SingleValidationMessage
{
    /**
     * バリデーションエラーメッセージを整形する
     *
     * @param Validator $validator
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = collect($validator->errors());
        $messages = $errors->map(fn($errorMessages) => $errorMessages[0]);

        throw new HttpResponseException(response()->json(
            ['message' => $messages],
            StatusCode::HTTP_BAD_REQUEST
        ));
    }
}
