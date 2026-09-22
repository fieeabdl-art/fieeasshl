<?php

namespace App\Observers;

use App\Models\PortfolioPhase;
use App\Models\ProjectStage;
use App\Services\AdminActivityLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Dipasang ke model-model konten di AppServiceProvider::boot(). Otomatis
 * mencatat setiap create/update/delete yang dilakukan lewat guard admin
 * ke tabel admin_activities, supaya muncul di notifikasi & riwayat
 * perubahan tanpa perlu nulis logging manual di tiap controller.
 */
class AdminActivityObserver
{
    /** Nama tampilan Bahasa Indonesia per model, mis. Portfolio => "Portofolio". */
    protected array $labels = [
        'Service' => 'Layanan',
        'Portfolio' => 'Portofolio',
        'Testimonial' => 'Testimonial',
        'Faq' => 'FAQ',
        'Workflow' => 'Alur Kerja',
        'TeamProfile' => 'Anggota Tim',
        'ClientPartner' => 'Klien & Mitra',
        'AffiliatedDivision' => 'Divisi Terafiliasi',
        'HeroSlide' => 'Slide Hero',
        'Setting' => 'Pengaturan Website',
        'Admin' => 'Akun Admin',
        'PortfolioPhase' => 'Tahapan Portofolio',
        'Project' => 'Proyek',
        'ProjectStage' => 'Tahapan Proyek',
    ];

    public function created(Model $model): void
    {
        $this->log($model, 'created', 'menambahkan');
    }

    public function updated(Model $model): void
    {
        // Login menyentuh remember_token & pengaturan lain menyentuh
        // banyak kolom sekaligus; hindari mencatat noise (mis. hanya
        // updated_at yang berubah, atau perubahan cuma dari sisi sistem).
        if ($model->wasChanged(['remember_token']) && count($model->getChanges()) <= 1) {
            return;
        }

        $this->log($model, 'updated', 'memperbarui');
    }

    public function deleted(Model $model): void
    {
        $this->log($model, 'deleted', 'menghapus');
    }

    protected function log(Model $model, string $action, string $verb): void
    {
        // Hanya catat perubahan yang dilakukan lewat sesi admin yang
        // sedang login (Web atau API) — mencegah noise dari seeder/factory/job.
        if (! Auth::guard('admin')->check() && ! Auth::guard('sanctum')->check()) {
            return;
        }

        $basename = class_basename($model);
        $label = $this->labels[$basename] ?? $basename;

        $title = $model->title ?? $model->name ?? $model->question ?? $model->site_name ?? null;

        if ($model instanceof PortfolioPhase) {
            $portfolio = $model->portfolio;
            $title = "{$model->title} pada Portofolio '{$portfolio?->title}'";
        } elseif ($model instanceof ProjectStage) {
            $project = $model->project;
            $title = "{$model->name} pada Proyek '{$project?->name}'";
        }

        $titlePart = $title ? " '{$title}'" : '';

        $description = "{$verb} {$label}{$titlePart}";

        AdminActivityLogger::log(
            action: $action,
            description: Str::ucfirst($description),
            subjectType: $basename,
            subjectId: $model->getKey(),
        );
    }
}
