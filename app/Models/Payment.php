<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Payment
 *
 * @version February 22, 2020, 7:06 am UTC
 *
 * @property int $id
 * @property string $payment_date
 * @property int $account_id
 * @property string $pay_to
 * @property float $amount
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account $account
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment wherePayTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Account[] $accounts
 * @property-read int|null $accounts_count
 * @property int $is_default
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereIsDefault($value)
 */
class Payment extends Model
{
    public $table = 'payments';

    public $fillable = [
        'payment_date',
        'account_id',
        'pay_to',
        'currency_symbol',
        'description',
        'amount',
    ];

    protected $casts = [
        'id' => 'integer',
        'account_id' => 'integer',
        'pay_to' => 'string',
        'payment_date' => 'date',
        'currency_symbol' => 'string',
        'description' => 'string',
        'amount' => 'string',
    ];

    public static $rules = [
        'payment_date' => 'required',
        'account_id' => 'required',
        'pay_to' => 'required',
        'amount' => 'required',
        'description' => 'nullable|string',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function accounts(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
}
