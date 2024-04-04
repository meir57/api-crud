<?php

namespace App\Http\Requests;

use App\Dto\UserDto;
use App\Http\Responses\UnprocessableEntityResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class UserAuthRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'email' => __('Email is not specified.'),
            'email.email' => __('Email is not valid.'),
            'password' => __('Password is not specified.'),
            'password.min' => __('Password should be at least 8 symbols.'),
        ];
    }

    public function getDto(): UserDto
    {
        return new UserDto(
            $this->email,
            $this->password,
        );
    }

    protected function failedValidation(Validator $validator): void
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            new UnprocessableEntityResponse($errors)
        );
    }
}
