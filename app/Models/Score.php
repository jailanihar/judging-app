<?php

namespace App\Models;

use Database\Factories\ScoreFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $judging_assignment_id
 * @property int $criterion_id
 * @property int $score
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Database\Factories\ScoreFactory factory($count = null, $state = [])
 */
class Score extends Model
{
    /** @use HasFactory<ScoreFactory> */
    use HasFactory;

    protected $fillable = ['judging_assignment_id', 'criterion_id', 'score'];

    protected function casts(): array
    {
        return [
            'score' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<JudgingAssignment, Score>
     */
    public function judgingAssignment(): BelongsTo
    {
        return $this->belongsTo(JudgingAssignment::class);
    }

    /**
     * @return BelongsTo<Criterion, Score>
     */
    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class);
    }
}
