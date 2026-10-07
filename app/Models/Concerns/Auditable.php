<?php

namespace App\Models\Concerns;

use App\Models\AuditLog;

/**
 * Records created / updated / deleted on the model in the audit log.
 */
trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(fn ($m) => AuditLog::record('created', $m, null, null, $m->getAttributes()));

        static::updated(function ($m) {
            $changes = $m->getChanges();
            unset($changes['updated_at'], $changes['remember_token']);

            $passwordChanged = array_key_exists('password', $changes);

            // values of masked fields are never stored, but the fact is
            $visible = array_diff_key($changes, array_flip(AuditLog::MASKED));

            if ($visible === [] && ! $passwordChanged) {
                return;
            }

            AuditLog::record(
                'updated',
                $m,
                $passwordChanged ? 'Password changed' : null,
                array_intersect_key($m->getOriginal(), $changes),
                $changes
            );
        });

        static::deleted(fn ($m) => AuditLog::record('deleted', $m, null, $m->getOriginal(), null));
    }
}
