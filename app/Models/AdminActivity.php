<?php

namespace App\Models;

use App\Services\AdminActivityLogger;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $admin_id
 * @property string $admin_name
 * @property string $action
 * @property string|null $subject_type
 * @property int|null $subject_id
 * @property string $description
 * @property string|null $device
 * @property string|null $user_agent
 * @property Carbon $created_at
 * @property-read Carbon $created_at_wib
 */
#[Fillable(['admin_id', 'admin_name', 'action', 'subject_type', 'subject_id', 'description', 'device', 'user_agent'])]
class AdminActivity extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Hanya aktivitas CRUD (created/updated/deleted) — dipakai di mana pun
     * "Riwayat Perubahan" atau notifikasi ditampilkan, supaya aktivitas
     * non-perubahan (mis. login) tidak ikut nongol di sana.
     */
    public function scopeCrud(Builder $query): Builder
    {
        return $query->whereIn('action', AdminActivityLogger::CRUD_ACTIONS);
    }

    /**
     * created_at, dibaca ulang langsung dari nilai mentah di database lalu
     * ditandai eksplisit sebagai jam dinding Asia/Jakarta.
     *
     * Kenapa tidak langsung pakai `$this->created_at`? Karena cast
     * "datetime" bawaan Eloquent menandai jam yang tersimpan memakai
     * timezone default aplikasi (config('app.timezone')) — kalau nilai itu
     * beda dari Asia/Jakarta, hasilnya jam yang ditampilkan bisa "meleset"
     * beberapa jam dari jam sebenarnya, dan diffForHumans() jadi salah
     * (pernah muncul sebagai "X jam lagi" padahal sudah lewat). Baris ini
     * membaca ulang string mentahnya dan mengunci timezone-nya sendiri,
     * supaya hasilnya selalu benar apa pun konfigurasi timezone aplikasi.
     */
    protected function createdAtWib(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->getRawOriginal('created_at'), 'Asia/Jakarta'),
        );
    }
}
