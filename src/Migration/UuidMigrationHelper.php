<?php declare(strict_types=1);

namespace Simlux\LaravelModelUuid\Uuid\Migration;

use Illuminate\Database\Schema\Blueprint;

class UuidMigrationHelper
{
    /**
     * @param Blueprint $table
     * @param string    $comment
     */
    public static function uuid(Blueprint $table, string $comment = null)
    {
        $table->char('uuid', 36);
        $table->unique('uuid', 'uuid');
        if (!is_null($comment)) {
            $table->comment = $comment;
        }
    }
}