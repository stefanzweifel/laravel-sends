<?php

return [
    /*
     * The fully qualified class name of the `Send` model.
     */
    'send_model' => \Wnx\Sends\Models\Send::class,

    'headers' => [
        /**
         * Header containing the encrypted FQN of the mailable class.
         */
        'mail_class' => env('SENDS_HEADERS_MAIL_CLASS', 'X-Laravel-Mail-Class'),

        /**
         * Header containing an encrypted JSON object with information which
         * Eloquent models are associated with the mailable class.
         */
        'models' => env('SENDS_HEADERS_MAIL_MODELS', 'X-Laravel-Mail-Models'),

        /**
         * Header containing unique ID of the sent out mailable class.
         */
        'send_uuid' => env('SENDS_HEADERS_SEND_UUID', 'X-Laravel-Send-UUID'),
    ],
];
