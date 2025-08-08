<?php

namespace Netauratech\ContentManager\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Netauratech\CoreCms\Form\FormRegistry;

class ContentFormRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $contentId = $this->route('content') ? $this->route('content')->id : null;

        $staticRules = [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('contents')->ignore($contentId),
            ],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'type' => ['required', 'string', Rule::in(['page', 'article', 'header', 'footer'])],
            'status' => ['required', 'string', Rule::in(['draft', 'published', 'archived'])],
            'published_at' => ['nullable', 'date'],
        ];

        $dynamicRules = [];
        $formRegistry = app(FormRegistry::class);
        $formFields = $formRegistry->getFormFields('content_form');

        foreach ($formFields as $fieldDefinition) {
            if (isset($fieldDefinition['validation'])) {
                $dynamicRules[$fieldDefinition['name']] = $fieldDefinition['validation'];
            }
        }

        return array_merge($staticRules, $dynamicRules);
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->input('slug') === null) {
            $this->merge([
                'slug' => Str::slug($this->input('title')),
            ]);
        }

        if ($this->route('type') && $this->input('type') === null) {
            $this->merge(['type' => $this->route('type')]);
        }
    }
}