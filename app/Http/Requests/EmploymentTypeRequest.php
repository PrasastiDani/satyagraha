<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmploymentTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin') ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $employmentTypeId = $this
            ->route('employment_type')
            ?->getKey();

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('employment_types', 'name')
                    ->ignore($employmentTypeId),
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama tipe pekerjaan',
            'description' => 'deskripsi',
            'is_active' => 'status',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama tipe pekerjaan wajib diisi.',
            'name.unique' => 'Nama tipe pekerjaan sudah digunakan.',
            'description.max' => 'Deskripsi maksimal 2.000 karakter.',
        ];
    }
}
