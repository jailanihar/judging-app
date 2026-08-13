<?php

namespace App\Models;

use Database\Factories\JudgingAssignmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $project_id
 * @property string $stage
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Database\Factories\JudgingAssignmentFactory factory($count = null, $state = [])
 */
class JudgingAssignment extends Model
{
    /** @use HasFactory<JudgingAssignmentFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'project_id', 'stage', 'status'];

    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }

    /**
     * @return BelongsTo<User, JudgingAssignment>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Project, JudgingAssignment>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return HasMany<Score, JudgingAssignment>
     */
    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }
}
