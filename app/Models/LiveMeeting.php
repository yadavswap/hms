<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class LiveMeeting
 *
 * @property int $id
 * @property string $consultation_title
 * @property string $consultation_date
 * @property string $consultation_duration_minutes
 * @property int $host_video
 * @property int $participant_video
 * @property string|null $description
 * @property string $created_by
 * @property array|null $meta
 * @property string $time_zone
 * @property string $password
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $status_text
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $members
 * @property-read int|null $members_count
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting query()
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting whereConsultationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting whereConsultationDurationMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting whereConsultationTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting whereHostVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting whereParticipantVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting whereTimeZone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 *
 * @property string $meeting_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LiveMeeting whereMeetingId($value)
 */
class LiveMeeting extends Model
{
    protected $table = 'live_meetings';

    protected $fillable = [
        'consultation_title',
        'consultation_date',
        'consultation_duration_minutes',
        'description',
        'meta',
        'created_by',
        'password',
        'host_video',
        'participant_video',
        'status',
        'meeting_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'consultation_title' => 'string',
        'consultation_date' => 'date',
        'consultation_duration_minutes' => 'string',
        'description' => 'string',
        'created_by' => 'integer',
        'password' => 'string',
        'host_video' => 'integer',
        'participant_video' => 'integer',
        'status' => 'integer',
        'meeting_id' => 'integer',
        'meta' => 'array',
    ];

    const STATUS_AWAITED = 0;

    const STATUS_CANCELLED = 1;

    const STATUS_FINISHED = 2;

    const status = [
        self::STATUS_AWAITED => 'Awaited',
        self::STATUS_CANCELLED => 'Cancelled',
        self::STATUS_FINISHED => 'Finished',
    ];

    const FILTER_STATUS = [
        0 => 'All',
        1 => 'Awaited',
        2 => 'Cancelled',
        3 => 'Finished',
    ];

    public static $rules = [
        'consultation_title' => 'required',
        'consultation_date' => 'required',
        'consultation_duration_minutes' => 'required|min:0|max:720',
    ];

    protected $appends = ['status_text'];

    public function getStatusTextAttribute()
    {
        return self::status[$this->status];
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'live_meetings_candidates', 'live_meeting_id', 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
