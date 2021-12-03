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
 * @property-read ?Carbon $sent_at
 * @property-read ?Carbon $delivered_at
 * @property-read int $opens
 * @property-read ?Carbon $last_opened_at
 * @property-read int $clicks
 * @property-read ?Carbon $last_clicked_at
 * @property-read ?Carbon $complained_at
 * @property-read ?Carbon $permanent_bounced_at
 * @property-read ?Carbon $rejected_at
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

    public function scopeByMessageId(Builder $builder, string $messageId): void
    {
        $builder->where('message_id', $messageId);
    }

    public function scopeByMailClass(Builder $builder, string $mailClass): void
    {
        $builder->where('mail_class', $mailClass);
    }
}
