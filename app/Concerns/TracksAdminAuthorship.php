<?php

namespace App\Concerns;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Adds a belongsTo relation to the Admin who last created/updated the
 * record, backed by the `updated_by` column. Used to show "Terakhir
 * diubah oleh: ..." in the admin CMS.
 */
trait TracksAdminAuthorship
{
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
