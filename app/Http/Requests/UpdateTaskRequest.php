<?php

namespace App\Http\Requests;

use App\Dto\Task\TaskDto;
use App\Enums\Status\StatusEnum;
use App\Http\Responses\UnprocessableEntityResponse;
use App\Rules\TaskStatusRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UpdateTaskRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable'],
            'description' => ['nullable'],
            'status' => ['nullable', new TaskStatusRule()],
        ];
    }

    public function getDto(): TaskDto
    {
        return new TaskDto(
            $this->name ?? '', 
            $this->description, 
            StatusEnum::tryFrom($this->status) ?? StatusEnum::UNFINISHED,
            auth()->user()->getAuthIdentifier(),
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
