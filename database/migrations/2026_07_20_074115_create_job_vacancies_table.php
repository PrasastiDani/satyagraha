<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id();

            /*
             * Master data.
             *
             * Department atau employment type tidak boleh dihapus
             * selama masih dipakai oleh lowongan.
             */
            $table->foreignId('department_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('employment_type_id')
                ->constrained()
                ->restrictOnDelete();

            /*
             * Admin pembuat lowongan.
             *
             * Jika akun admin dihapus, lowongan tetap disimpan dan
             * created_by diubah menjadi null.
             */
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('title', 160);
            $table->string('slug', 180)->unique();

            /*
             * Ringkasan singkat untuk kartu/list lowongan.
             */
            $table->text('summary')->nullable();

            /*
             * Isi utama lowongan.
             */
            $table->longText('description');

            $table->longText('responsibilities')->nullable();
            $table->longText('requirements')->nullable();

            $table->string('location', 150)->nullable();

            /*
             * Simpan path file, bukan binary gambarnya.
             *
             * Contoh:
             * job-vacancies/front-office-staff.webp
             */
            $table->string('thumbnail')->nullable();

            /*
             * Nilai awal:
             * draft, published, closed, archived
             */
            $table->string('status', 20)
                ->default('draft');

            /*
             * Waktu lowongan mulai diterbitkan.
             */
            $table->dateTime('published_at')->nullable();

            /*
             * Batas terakhir pelamar mengirim lamaran.
             * Null berarti tidak memiliki deadline khusus.
             */
            $table->dateTime('application_deadline')->nullable();

            $table->timestamps();
            $table->softDeletes();

            /*
             * Membantu query daftar lowongan publik.
             */
            $table->index([
                'status',
                'published_at',
            ]);

            $table->index('application_deadline');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
