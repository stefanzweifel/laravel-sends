# Upgrading

## From v0.1 to v1.0

The major change coming to the first stable release is the departure from the term "message_id" in favour of "uuid". (See [#5](https://github.com/stefanzweifel/laravel-sends/pull/5) for details)

- Rename the `message_id` column in the `sends`-database table to `uuid` (see migration below)
- Change usage of `Send::byMessageId($messageId)` to `Send::forUuid($uuid)`
- If used, update `AttachCustomMessageIdListener` to `AttachSendUuidListener` in your event listener
- If customized, update the env variable `SENDS_HEADERS_MESSAGE_ID` to `SENDS_HEADERS_SEND_UUID`
- If used, update usages of the `sends.headers.custom_message_id` configuration key to `sends.headers.send_uuid`
- Change usage of `Send::byMailClass($mailClass)` to `Send::forMailClass($mailClass)`

Run the following command to create a new migration.

```bash
php artisan make:migration RenameMessageIdToUuid --table=sends
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameMessageIdToUuid extends Migration
{
    public function up()
    {
        Schema::table('sends', function (Blueprint $table) {
            $table->renameColumn('message_id', 'uuid');
        });
    }
}
```
