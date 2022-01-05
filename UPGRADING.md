# Upgrading

## From v1.0 to v2.0

There are no breaking changes besides a new `content`-column in  the `sends`-table. 
The package is still young and not too many people are using v1. That is why I've decided to not include an additional migration in the package, but force you as a user to add that column yourself.
To learn more about the new feature check out [#6](https://github.com/stefanzweifel/laravel-sends/pull/6).

The upgrade should only take a couple of seconds. Execute the following artisan command to create the migration file. Paste my example below into the file and you're good to go.

```bash
php artisan make:migration AddContentColumnToSendsTable --table=sends
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContentColumnToSendsTable extends Migration
{
    public function up()
    {
        Schema::table('sends', function (Blueprint $table) {
            $table->text('content')->nullable()->after('subject');
        });
    }
}
```


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
php artisan make:migration RenameMessageIdToUuidInSendsTable --table=sends
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
