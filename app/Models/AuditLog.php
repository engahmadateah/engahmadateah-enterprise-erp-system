<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'event', 'auditable_type', 'auditable_id', 'description',
        'old_values', 'new_values', 'ip_address', 'user_agent', 'created_at',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
            'created_at' => 'datetime',
        ];
    }

    /** Never store these, whatever the model is. */
    public const MASKED = ['password', 'remember_token', 'current_password'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record(
        string $event,
        ?Model $model = null,
        ?string $description = null,
        ?array $old = null,
        ?array $new = null,
        ?int $userId = null
    ): void {
        try {
            $mask = fn (?array $v) => $v === null ? null
                : array_diff_key($v, array_flip(self::MASKED));

            $request = request();

            static::create([
                'user_id'        => $userId ?? auth()->id(),
                'event'          => $event,
                'auditable_type' => $model ? class_basename($model) : null,
                'auditable_id'   => $model?->getKey(),
                'description'    => $description ? mb_substr($description, 0, 500) : null,
                'old_values'     => $mask($old),
                'new_values'     => $mask($new),
                'ip_address'     => app()->runningInConsole() ? null : $request->ip(),
                'user_agent'     => app()->runningInConsole() ? null : mb_substr((string) $request->userAgent(), 0, 255),
                'created_at'     => now(),
            ]);
        } catch (\Throwable $e) {
            // auditing must never break the business operation
            report($e);
        }
    }
}
