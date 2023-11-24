<?php

return [
    /*
     * The fully qualified class name of the `Send` model.
     */
    'send_model' => \Wnx\Sends\Models\Send::class,

    /**
     * If set to true, the content of sent mails is saved to the database.
     */
    'store_content' => env('SENDS_STORE_CONTENT', false),

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
         * Set to: Message-ID  when you want to save the message id instead of a custom value
         */
        'send_uuid' => env('SENDS_HEADERS_SEND_UUID', 'X-Laravel-Send-UUID'),
    ],
];
