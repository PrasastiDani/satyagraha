<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmploymentTypeRequest;
use App\Models\EmploymentType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class EmploymentTypeController extends Controller
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
                Rule::in(['active', 'inactive']),
            ],
        ]);

        $search = trim($filters['search'] ?? '');

        $employmentTypes = EmploymentType::query()
            ->withCount('jobVacancies')
            ->when(
                $search,
                function (Builder $query, string $search): void {
                    $query->where(
                        function (Builder $query) use ($search): void {
                            $query
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere(
                                    'description',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            )
            ->when(
                ($filters['status'] ?? null) === 'active',
                fn(Builder $query): Builder =>
                $query->where('is_active', true)
            )
            ->when(
                ($filters['status'] ?? null) === 'inactive',
                fn(Builder $query): Builder =>
                $query->where('is_active', false)
            )
            ->latest('id')
            ->paginate(10)
            ->withQueryString()
            ->through(
                fn(EmploymentType $employmentType): array => [
                    'id' => $employmentType->id,
                    'name' => $employmentType->name,
                    'slug' => $employmentType->slug,
                    'description' => $employmentType->description,
                    'is_active' => $employmentType->is_active,
                    'job_vacancies_count' =>
                    $employmentType->job_vacancies_count,
                    'created_at' => $employmentType
                        ->created_at
                        ?->format('d M Y'),
                ]
            );

        return Inertia::render(
            'admin/employment-types/Index',
            [
                'employmentTypes' => $employmentTypes,

                'filters' => [
                    'search' => $search,
                    'status' => $filters['status'] ?? '',
                ],
            ]
        );
    }

    public function create(): Response
    {
        return Inertia::render(
            'admin/employment-types/Create'
        );
    }

    public function store(
        EmploymentTypeRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        $data['slug'] = $this->generateUniqueSlug(
            $data['name']
        );

        EmploymentType::create($data);

        return redirect()
            ->route('admin.employment-types.index')
            ->with(
                'success',
                'Tipe pekerjaan berhasil ditambahkan.'
            );
    }

    public function edit(
        EmploymentType $employmentType
    ): Response {
        return Inertia::render(
            'admin/employment-types/Edit',
            [
                'employmentType' => [
                    'id' => $employmentType->id,
                    'name' => $employmentType->name,
                    'slug' => $employmentType->slug,
                    'description' => $employmentType->description,
                    'is_active' => $employmentType->is_active,
                ],
            ]
        );
    }

    public function update(
        EmploymentTypeRequest $request,
        EmploymentType $employmentType
    ): RedirectResponse {
        $data = $request->validated();

        $data['slug'] = $this->generateUniqueSlug(
            $data['name'],
            $employmentType->id
        );

        $employmentType->update($data);

        return redirect()
            ->route('admin.employment-types.index')
            ->with(
                'success',
                'Tipe pekerjaan berhasil diperbarui.'
            );
    }

    public function destroy(
        EmploymentType $employmentType
    ): RedirectResponse {
        if ($employmentType->jobVacancies()->exists()) {
            return back()->with(
                'error',
                'Tipe pekerjaan tidak dapat dihapus karena masih digunakan oleh lowongan kerja.'
            );
        }

        $employmentType->delete();

        return back()->with(
            'success',
            'Tipe pekerjaan berhasil dihapus.'
        );
    }

    private function generateUniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'tipe-pekerjaan';
        }

        $slug = $baseSlug;
        $counter = 2;

        while (
            EmploymentType::query()
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
