<?php

namespace App\Http\Requests;

use App\Enums\JobVacancyStatus;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Validator;

class JobVacancyRequest extends FormRequest
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
        return [
            'department_id' => [
                'required',
                'integer',
                'exists:departments,id',
            ],

            'employment_type_id' => [
                'required',
                'integer',
                'exists:employment_types,id',
            ],

            'title' => [
                'required',
                'string',
                'max:160',
            ],

            'summary' => [
                'nullable',
                'string',
                'max:500',
            ],

            'description' => [
                'required',
                'string',
            ],

            'responsibilities' => [
                'nullable',
                'string',
            ],

            'requirements' => [
                'nullable',
                'string',
            ],

            'location' => [
                'nullable',
                'string',
                'max:150',
            ],

            'status' => [
                'required',
                Rule::enum(JobVacancyStatus::class),
            ],

            'published_at' => [
                'nullable',
                'date',
            ],

            'application_deadline' => [
                'nullable',
                'date',
            ],

            'thumbnail' => [
                'nullable',
                File::image()
                    ->types(['jpg', 'jpeg', 'png', 'webp'])
                    ->max('4mb'),
            ],

            'remove_thumbnail' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    /**
     * Validasi hubungan tanggal publikasi dan deadline.
     *
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if (
                    $validator->errors()->has('published_at') ||
                    $validator->errors()->has('application_deadline') ||
                    ! $this->filled('application_deadline')
                ) {
                    return;
                }

                $publishedAt = $this->filled('published_at')
                    ? Carbon::parse($this->input('published_at'))
                    : now();

                $deadline = Carbon::parse(
                    $this->input('application_deadline')
                );

                if ($deadline->lt($publishedAt)) {
                    $validator->errors()->add(
                        'application_deadline',
                        'Batas pendaftaran tidak boleh sebelum waktu publikasi.'
                    );
                }
            },
        ];
    }

    public function attributes(): array
    {
        return [
            'department_id' => 'departemen',
            'employment_type_id' => 'tipe pekerjaan',
            'title' => 'judul lowongan',
            'summary' => 'ringkasan',
            'description' => 'deskripsi',
            'responsibilities' => 'tanggung jawab',
            'requirements' => 'persyaratan',
            'location' => 'lokasi',
            'status' => 'status',
            'published_at' => 'waktu publikasi',
            'application_deadline' => 'batas pendaftaran',
            'thumbnail' => 'thumbnail',
        ];
    }

    public function messages(): array
    {
        return [
            'department_id.required' => 'Departemen wajib dipilih.',
            'employment_type_id.required' => 'Tipe pekerjaan wajib dipilih.',
            'title.required' => 'Judul lowongan wajib diisi.',
            'description.required' => 'Deskripsi lowongan wajib diisi.',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 4 MB.',
        ];
    }
}
