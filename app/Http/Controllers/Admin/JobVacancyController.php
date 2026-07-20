<?php

namespace App\Http\Controllers\Admin;

use App\Enums\JobVacancyStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobVacancyRequest;
use App\Models\Department;
use App\Models\EmploymentType;
use App\Models\JobVacancy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class JobVacancyController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:100',
            ],

            'status' => [
                'nullable',
                Rule::enum(JobVacancyStatus::class),
            ],

            'department_id' => [
                'nullable',
                'integer',
                'exists:departments,id',
            ],

            'employment_type_id' => [
                'nullable',
                'integer',
                'exists:employment_types,id',
            ],
        ]);

        $search = trim($filters['search'] ?? '');

        $vacancies = JobVacancy::query()
            ->with([
                'department:id,name',
                'employmentType:id,name',
                'creator:id,name,username',
            ])
            ->when(
                $search,
                function (Builder $query, string $search): void {
                    $query->where(
                        function (Builder $query) use ($search): void {
                            $query
                                ->where('title', 'like', "%{$search}%")
                                ->orWhere('summary', 'like', "%{$search}%")
                                ->orWhere('location', 'like', "%{$search}%");
                        }
                    );
                }
            )
            ->when(
                $filters['status'] ?? null,
                fn(Builder $query, string $status): Builder =>
                $query->where('status', $status)
            )
            ->when(
                $filters['department_id'] ?? null,
                fn(Builder $query, int|string $departmentId): Builder =>
                $query->where('department_id', $departmentId)
            )
            ->when(
                $filters['employment_type_id'] ?? null,
                fn(
                    Builder $query,
                    int|string $employmentTypeId
                ): Builder => $query->where(
                    'employment_type_id',
                    $employmentTypeId
                )
            )
            ->latest('id')
            ->paginate(10)
            ->withQueryString()
            ->through(
                fn(JobVacancy $vacancy): array => [
                    'id' => $vacancy->id,
                    'title' => $vacancy->title,
                    'slug' => $vacancy->slug,
                    'summary' => $vacancy->summary,
                    'location' => $vacancy->location,

                    'status' => $vacancy->status->value,
                    'status_label' => $vacancy->status->label(),

                    'department' => [
                        'id' => $vacancy->department->id,
                        'name' => $vacancy->department->name,
                    ],

                    'employment_type' => [
                        'id' => $vacancy->employmentType->id,
                        'name' => $vacancy->employmentType->name,
                    ],

                    'creator' => $vacancy->creator
                        ? [
                            'name' => $vacancy->creator->name,
                            'username' => $vacancy->creator->username,
                        ]
                        : null,

                    'thumbnail_url' => $vacancy->thumbnail
                        ? Storage::disk('public')->url(
                            $vacancy->thumbnail
                        )
                        : null,

                    'published_at' => $vacancy
                        ->published_at
                        ?->format('d M Y H:i'),

                    'application_deadline' => $vacancy
                        ->application_deadline
                        ?->format('d M Y H:i'),

                    'created_at' => $vacancy
                        ->created_at
                        ?->format('d M Y H:i'),
                ]
            );

        return Inertia::render('admin/job-vacancies/Index', [
            'vacancies' => $vacancies,

            'filters' => [
                'search' => $search,
                'status' => $filters['status'] ?? '',
                'department_id' => $filters['department_id'] ?? '',
                'employment_type_id' =>
                $filters['employment_type_id'] ?? '',
            ],

            'departments' => Department::query()
                ->orderBy('name')
                ->get(['id', 'name']),

            'employmentTypes' => EmploymentType::query()
                ->orderBy('name')
                ->get(['id', 'name']),

            'statuses' => JobVacancyStatus::options(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/job-vacancies/Create', [
            'departments' => Department::query()
                ->active()
                ->orderBy('name')
                ->get(['id', 'name']),

            'employmentTypes' => EmploymentType::query()
                ->active()
                ->orderBy('name')
                ->get(['id', 'name']),

            'statuses' => JobVacancyStatus::options(),
        ]);
    }

    public function store(
        JobVacancyRequest $request
    ): RedirectResponse {
        $data = $request->safe()->except([
            'thumbnail',
            'remove_thumbnail',
        ]);

        $data['slug'] = $this->generateUniqueSlug(
            $data['title']
        );

        if (
            $data['status'] === JobVacancyStatus::Published->value &&
            blank($data['published_at'] ?? null)
        ) {
            $data['published_at'] = now();
        }

        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request
                ->file('thumbnail')
                ->store('job-vacancies', 'public');
        }

        try {
            $vacancy = new JobVacancy($data);

            $vacancy->thumbnail = $thumbnailPath;

            $vacancy
                ->creator()
                ->associate($request->user());

            $vacancy->save();
        } catch (Throwable $exception) {
            if ($thumbnailPath) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            throw $exception;
        }

        return redirect()
            ->route('admin.job-vacancies.index')
            ->with(
                'success',
                'Lowongan kerja berhasil ditambahkan.'
            );
    }

    public function edit(
        JobVacancy $jobVacancy
    ): Response {
        return Inertia::render('admin/job-vacancies/Edit', [
            'vacancy' => [
                'id' => $jobVacancy->id,
                'department_id' => $jobVacancy->department_id,
                'employment_type_id' =>
                $jobVacancy->employment_type_id,

                'title' => $jobVacancy->title,
                'summary' => $jobVacancy->summary,
                'description' => $jobVacancy->description,
                'responsibilities' =>
                $jobVacancy->responsibilities,
                'requirements' => $jobVacancy->requirements,
                'location' => $jobVacancy->location,

                'status' => $jobVacancy->status->value,

                'published_at' => $jobVacancy
                    ->published_at
                    ?->format('Y-m-d\TH:i'),

                'application_deadline' => $jobVacancy
                    ->application_deadline
                    ?->format('Y-m-d\TH:i'),

                'thumbnail_url' => $jobVacancy->thumbnail
                    ? Storage::disk('public')->url(
                        $jobVacancy->thumbnail
                    )
                    : null,
            ],

            /*
             * Data yang sedang digunakan tetap ditampilkan
             * meskipun sudah tidak aktif.
             */
            'departments' => Department::query()
                ->where(function (Builder $query) use ($jobVacancy): void {
                    $query
                        ->where('is_active', true)
                        ->orWhere('id', $jobVacancy->department_id);
                })
                ->orderBy('name')
                ->get(['id', 'name']),

            'employmentTypes' => EmploymentType::query()
                ->where(function (Builder $query) use ($jobVacancy): void {
                    $query
                        ->where('is_active', true)
                        ->orWhere(
                            'id',
                            $jobVacancy->employment_type_id
                        );
                })
                ->orderBy('name')
                ->get(['id', 'name']),

            'statuses' => JobVacancyStatus::options(),
        ]);
    }

    public function update(
        JobVacancyRequest $request,
        JobVacancy $jobVacancy
    ): RedirectResponse {
        $data = $request->safe()->except([
            'thumbnail',
            'remove_thumbnail',
        ]);

        $data['slug'] = $this->generateUniqueSlug(
            $data['title'],
            $jobVacancy->id
        );

        if (
            $data['status'] === JobVacancyStatus::Published->value &&
            blank($data['published_at'] ?? null)
        ) {
            $data['published_at'] =
                $jobVacancy->published_at ?? now();
        }

        $oldThumbnail = $jobVacancy->thumbnail;
        $newThumbnail = null;
        $removeThumbnail = $request->boolean('remove_thumbnail');

        if ($request->hasFile('thumbnail')) {
            $newThumbnail = $request
                ->file('thumbnail')
                ->store('job-vacancies', 'public');
        }

        try {
            $jobVacancy->fill($data);

            if ($newThumbnail) {
                $jobVacancy->thumbnail = $newThumbnail;
            } elseif ($removeThumbnail) {
                $jobVacancy->thumbnail = null;
            }

            $jobVacancy->save();
        } catch (Throwable $exception) {
            if ($newThumbnail) {
                Storage::disk('public')->delete($newThumbnail);
            }

            throw $exception;
        }

        if (
            $oldThumbnail &&
            ($newThumbnail || $removeThumbnail)
        ) {
            Storage::disk('public')->delete($oldThumbnail);
        }

        return redirect()
            ->route('admin.job-vacancies.index')
            ->with(
                'success',
                'Lowongan kerja berhasil diperbarui.'
            );
    }

    public function destroy(
        JobVacancy $jobVacancy
    ): RedirectResponse {
        /*
         * Model memakai SoftDeletes, sehingga file thumbnail
         * tidak langsung dihapus.
         */
        $jobVacancy->delete();

        return back()->with(
            'success',
            'Lowongan kerja berhasil dipindahkan ke arsip.'
        );
    }

    private function generateUniqueSlug(
        string $title,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($title);

        if ($baseSlug === '') {
            $baseSlug = 'lowongan-kerja';
        }

        $slug = $baseSlug;
        $counter = 2;

        while (
            JobVacancy::withTrashed()
            ->where('slug', $slug)
            ->when(
                $ignoreId,
                fn(Builder $query): Builder =>
                $query->where('id', '!=', $ignoreId)
            )
            ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
