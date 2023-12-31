<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Visitor
 *
 * @property int $id
 * @property int $purpose
 * @property string $name
 * @property string|null $phone
 * @property string|null $id_card
 * @property string|null $no_of_person
 * @property string|null $date
 * @property string|null $in_time
 * @property string|null $out_time
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $document_url
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Visitor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Visitor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Visitor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Visitor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visitor whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visitor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visitor whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visitor whereInTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visitor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visitor whereNoOfPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visitor whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visitor whereOutTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visitor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visitor wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visitor whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Visitor extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'visitors';

    const PATH = 'visitors';

    const PURPOSE = [
        3 => 'Visit',
        1 => 'Enquiry',
        2 => 'Seminar',
    ];

    const FILTER_PURPOSE = [
        0 => 'All',
        3 => 'Visit',
        1 => 'Enquiry',
        2 => 'Seminar',
    ];

    protected $fillable = [
        'purpose',
        'name',
        'phone',
        'id_card',
        'no_of_person',
        'date',
        'in_time',
        'out_time',
        'note',
    ];

    protected $casts = [
        'id' => 'integer',
        'purpose' => 'string',
        'name' => 'string',
        'phone' => 'integer',
        'id_card' => 'string',
        'no_of_person' => 'integer',
        'date' => 'date',
        'note' => 'string',
    ];

    public static $rules = [
        'purpose' => 'required|string',
        'name' => 'required|string',
        'id_card' => 'string|nullable',
        'no_of_person' => 'integer|nullable',
        'date' => 'date|nullable',
        'in_time' => 'string|nullable',
        'out_time' => 'string|nullable',
        'note' => 'string|nullable',
    ];

    protected $appends = ['document_url'];

    public function getDocumentUrlAttribute()
    {
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return '';
    }

    public function getInTimeAttribute()
    {
        return $this->attributes['in_time'] ? \Carbon\Carbon::parse($this->attributes['in_time'])->Format('H:i:s') : null;
    }

    public function getOutTimeAttribute()
    {
        return $this->attributes['out_time'] ? \Carbon\Carbon::parse($this->attributes['out_time'])->Format('H:i:s') : null;
    }
}
