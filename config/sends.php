<?php

return [
    /*
     * The fully qualified class name of the send model.
     */
    'send_model' => \Wnx\Sends\Models\Send::class,

    'headers' => [
        /**
         * Header containing unique ID of the sent out mailable class.
         */
        'custom_message_id' => env('SENDS_HEADERS_CUSTOM_MESSAGE_ID', 'X-Laravel-Message-ID'),

        /**
         * Header containing the encrypted FQN of the mailable class.
         */
        'mail_class' => env('SENDS_HEADERS_MAIL_CLASS', 'X-Laravel-Mail-Class'),

        /**
         * Header containing an encrypted JSON object with information which
         * Eloquent models are associated with the mailable class.
         */
        'models' => env('SENDS_HEADERS_MAIL_MODELS', 'X-Laravel-Mail-Models'),
    ],
];
