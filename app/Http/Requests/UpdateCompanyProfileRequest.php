<?php

namespace App\Http\Requests;

use App\Models\CompanyProfiles;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     
     */
    public function rules(): array
    {
        $profile = $this->input('profile') ?? CompanyProfiles::find($this->route('company_profile'));

        return [
            'name' => ['sometimes', 'required', 'string', 'max:100'],
            'address' => ['sometimes', 'required', 'string', 'max:255'],
            'about_description' => ['nullable', 'string'],
            'home_description' => ['nullable', 'string'],
            'img_description' => [
                Rule::requiredIf(static function () use ($profile) {
                    return empty(optional($profile)->img_description);
                }),
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
            'img_home' => [
                Rule::requiredIf(static function () use ($profile) {
                    return empty(optional($profile)->img_home);
                }),
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
            'phone' => ['sometimes', 'required', 'string', 'max:20'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255'],
        ];
    }

    /**
     * Optionally prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'profile' => CompanyProfiles::find($this->route('company_profile')),
        ]);
    }
}
