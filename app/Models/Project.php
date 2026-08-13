<?php

namespace App\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $status
 * @property bool $is_judging_open
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Database\Factories\ProjectFactory factory($count = null, $state = [])
 */
class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'status', 'is_judging_open'];

    protected function casts(): array
    {
        return [
            'is_judging_open' => 'boolean',
        ];
    }

    /**
     * @return HasMany<JudgingAssignment>
     */
    /**
     * @return HasMany<JudgingAssignment, Project>
     */
    public function judgingAssignments(): HasMany
    {
        return $this->hasMany(JudgingAssignment::class);
    }
}
