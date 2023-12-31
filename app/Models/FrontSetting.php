<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\FrontSetting
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|FrontSetting newModelQuery()
 * @method static Builder|FrontSetting newQuery()
 * @method static Builder|FrontSetting query()
 * @method static Builder|FrontSetting whereCreatedAt($value)
 * @method static Builder|FrontSetting whereId($value)
 * @method static Builder|FrontSetting whereKey($value)
 * @method static Builder|FrontSetting whereType($value)
 * @method static Builder|FrontSetting whereUpdatedAt($value)
 * @method static Builder|FrontSetting whereValue($value)
 *
 * @mixin \Eloquent
 *
 * @property-read mixed $logo_url
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 */
class FrontSetting extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $table = 'front_settings';

    public const PATH = 'front-settings';

    public const HOME_IMAGE_PATH = 'homepage-image';

    const ABOUT_US = 1;

    const HOME_PAGE = 2;

    const APPOINTMENT = 3;

    const STATUS_ARR = [
        self::ABOUT_US => 'About Us',
    ];

    public static $rules = [
        'about_us_title' => 'required',
        'about_us_mission' => 'required',
        'about_us_image' => 'nullable',
    ];

    public $fillable = [
        'key',
        'value',
        'type',
    ];

    protected $casts = [
        'id' => 'integer',
        'key' => 'string',
        'value' => 'string',
        'type' => 'string',
    ];

    public function getLogoUrlAttribute()
    {
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return $this->value;
    }
}
