<?php

namespace App\Models;

use App\Models\Scopes\TaskVisibilityScope;
use App\Models\Traits\ModelBindingTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory, ModelBindingTrait;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description ?? '';
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new TaskVisibilityScope());
    }

    /*   relations   */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
