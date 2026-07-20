<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class DepartmentController extends Controller
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

        $departments = Department::query()
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
            ->latest()
            ->paginate(10)
            ->withQueryString()
            ->through(
                fn(Department $department): array => [
                    'id' => $department->id,
                    'name' => $department->name,
                    'slug' => $department->slug,
                    'description' => $department->description,
                    'is_active' => $department->is_active,
                    'job_vacancies_count' =>
                    $department->job_vacancies_count,
                    'created_at' => $department->created_at?->format(
                        'd M Y'
                    ),
                ]
            );

        return Inertia::render('admin/departments/Index', [
            'departments' => $departments,

            'filters' => [
                'search' => $search,
                'status' => $filters['status'] ?? '',
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/departments/Create');
    }

    public function store(
        DepartmentRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        $data['slug'] = $this->generateUniqueSlug(
            $data['name']
        );

        Department::create($data);

        return redirect()
            ->route('admin.departments.index')
            ->with(
                'success',
                'Departemen berhasil ditambahkan.'
            );
    }

    public function edit(
        Department $department
    ): Response {
        return Inertia::render('admin/departments/Edit', [
            'department' => [
                'id' => $department->id,
                'name' => $department->name,
                'slug' => $department->slug,
                'description' => $department->description,
                'is_active' => $department->is_active,
            ],
        ]);
    }

    public function update(
        DepartmentRequest $request,
        Department $department
    ): RedirectResponse {
        $data = $request->validated();

        /*
         * Slug ikut berubah apabila nama departemen berubah.
         */
        $data['slug'] = $this->generateUniqueSlug(
            $data['name'],
            $department->id
        );

        $department->update($data);

        return redirect()
            ->route('admin.departments.index')
            ->with(
                'success',
                'Departemen berhasil diperbarui.'
            );
    }

    public function destroy(
        Department $department
    ): RedirectResponse {
        /*
         * Jangan hapus departemen yang masih digunakan lowongan.
         */
        if ($department->jobVacancies()->exists()) {
            return back()->with(
                'error',
                'Departemen tidak dapat dihapus karena masih digunakan oleh lowongan kerja.'
            );
        }

        $department->delete();

        return back()->with(
            'success',
            'Departemen berhasil dihapus.'
        );
    }

    private function generateUniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'department';
        }

        $slug = $baseSlug;
        $counter = 2;

        while (
            Department::query()
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
