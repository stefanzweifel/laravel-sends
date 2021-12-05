<?php

declare(strict_types=1);

namespace Wnx\Sends\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wnx\Sends\Database\Factories\SendFactory;

/**
 * @property-read string $message_id
 * @property-read string $mail_class
 * @property-read string $subject
 * @property-read array $from
 * @property-read array $reply_to
 * @property-read array $to
 * @property-read array $cc
 * @property-read array $bcc
 * @property ?Carbon $sent_at
 * @property ?Carbon $delivered_at
 * @property int $opens
 * @property ?Carbon $last_opened_at
 * @property int $clicks
 * @property ?Carbon $last_clicked_at
 * @property ?Carbon $complained_at
 * @property ?Carbon $bounced_at
 * @property ?Carbon $permanent_bounced_at
 * @property ?Carbon $rejected_at
 * @method static Builder forMessageId(string $messageId)
 * @method static Builder forMailClass(string $mailClass)
 */
class Send extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'mail_class',
        'subject',
        'from',
        'reply_to',
        'to',
        'cc',
        'bcc',
        'sent_at',
        'delivered_at',
        'opens',
        'last_opened_at',
        'clicks',
        'last_clicked_at',
        'complained_at',
        'bounced_at',
        'permanent_bounced_at',
        'rejected_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'from' => 'json',
        'reply_to' => 'json',
        'to' => 'json',
        'cc' => 'json',
        'bcc' => 'json',
        'sent_at' => 'immutable_datetime',
        'delivered_at' => 'immutable_datetime',
        'opens' => 'integer',
        'last_opened_at' => 'immutable_datetime',
        'clicks' => 'integer',
        'last_clicked_at' => 'immutable_datetime',
        'complained_at' => 'immutable_datetime',
        'bounced_at' => 'immutable_datetime',
        'permanent_bounced_at' => 'immutable_datetime',
        'rejected_at' => 'immutable_datetime',
    ];

    protected static function newFactory(): SendFactory
    {
        return new SendFactory();
    }

    public function scopeForMessageId(Builder $builder, string $messageId): void
    {
        $builder->where('message_id', $messageId);
    }

    public function scopeForMailClass(Builder $builder, string $mailClass): void
    {
        $builder->where('mail_class', $mailClass);
    }
}
