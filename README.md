# Laravel Model UUID

## Installation
```
composer require imlux/laravel-model-uuid:dev-master
```
## Usage
Creates column uuid and unique index with the migration helper.
```php
<?php

use Illuminate\Database\Eloquent\Model;
use Simlux\LaravelModelUuid\Uuid\UuidModelTrait;

/**
 * Class MyModel
 *
 * @property int    $id
 * @property string $uuid
 *
 * @method static MyModel uuid(string $uuid)
 */
class MyModel extends Model
{
    use UuidModelTrait;
}
```

## Migration
```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Simlux\LaravelModelUuid\Migration\UuidMigrationHelper;

class CreateTableRevisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_models', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            UuidMigrationHelper::uuid($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_models');
    }
}

```