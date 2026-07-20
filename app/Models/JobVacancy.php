<?php

namespace App\Models;

use App\Enums\JobVacancyStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobVacancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'department_id',
        'employment_type_id',
        'title',
        'slug',
        'summary',
        'description',
        'responsibilities',
        'requirements',
        'location',
        'thumbnail',
        'status',
        'published_at',
        'application_deadline',
    ];

    protected function casts(): array
    {
        return [
            'status' => JobVacancyStatus::class,
            'published_at' => 'datetime',
            'application_deadline' => 'datetime',
        ];
    }

    /**
     * Departemen lowongan.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Tipe pekerjaan lowongan.
     */
    public function employmentType(): BelongsTo
    {
        return $this->belongsTo(EmploymentType::class);
    }

    /**
     * Admin yang membuat lowongan.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Lowongan yang sudah berstatus published dan sudah memasuki
     * waktu publikasinya.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', JobVacancyStatus::Published->value)
            ->where(function (Builder $query): void {
                $query
                    ->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Lowongan yang masih menerima pendaftaran.
     */
    public function scopeOpen(Builder $query): Builder
    {
        return $query
            ->published()
            ->where(function (Builder $query): void {
                $query
                    ->whereNull('application_deadline')
                    ->orWhere('application_deadline', '>=', now());
            });
    }

    /**
     * Memeriksa apakah lowongan masih dibuka.
     */
    public function isOpen(): bool
    {
        if ($this->status !== JobVacancyStatus::Published) {
            return false;
        }

        if ($this->published_at?->isFuture()) {
            return false;
        }

        return ! $this->application_deadline?->isPast();
    }
}
