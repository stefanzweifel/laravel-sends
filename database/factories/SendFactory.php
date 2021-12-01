<?php

namespace Wnx\Sends\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Wnx\Sends\Models\Send;
use Wnx\Sends\Tests\TestSupport\Mails\TestMailWithMailClassHeader;

class SendFactory extends Factory
{
    protected $model = Send::class;

    public function definition()
    {
        return [
            'message_id' => $this->faker->uuid,
            'mail_class' => TestMailWithMailClassHeader::class,
            'subject' => $this->faker->sentence(6),
            'from' => [
                $this->faker->email => $this->faker->firstName(),
            ],
            'to' => [
                $this->faker->email => $this->faker->firstName(),
            ],
            'cc' => null,
            'bcc' => null,
            'sent_at' => now(),
            'delivered_at' => null,
            'opens' => null,
            'last_opened_at' => null,
            'clicks' => null,
            'last_clicked_at' => null,
            'complained_at' => null,
            'permanent_bounced_at' => null,
            'rejected_at' => null,
        ];
    }

    public function hasCc(): SendFactory
    {
        return $this->state(function () {
            return [
                'cc' => [
                    $this->faker->email => $this->faker->firstName(),
                ],
            ];
        });
    }

    public function hasBcc(): SendFactory
    {
        return $this->state(function () {
            return [
                'bcc' => [
                    $this->faker->email => $this->faker->firstName(),
                ],
            ];
        });
    }
}
