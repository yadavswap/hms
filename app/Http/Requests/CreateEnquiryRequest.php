<?php

namespace App\Http\Requests;

use App\Models\Enquiry;
use App\Rules\ValidRecaptcha;
use Illuminate\Foundation\Http\FormRequest;

class CreateEnquiryRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $rules = Enquiry::$rules;
        if (config('app.recaptcha.sitekey')) {
            $rules['g-recaptcha-response'] = ['required', new ValidRecaptcha];
        }

        return $rules;
    }

    /**
     * @return array|string[]
     */
    public function attributes(): array
    {
        return Enquiry::$reCaptchaAttributes;
    }
}
