<?php

namespace App\Ship\Abstracts\Requests;

use Anik\Form\FormRequest as VendorFormRequest;
use App\Ship\Support\Facades\Responder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class FormRequest extends VendorFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }

    protected function validationFailed(): void
    {
        $errors = (new ValidationException($this->validator))->errors();
        throw new HttpResponseException(Responder::inputError($errors));
    }
}
