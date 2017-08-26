<?php declare(strict_types=1);

namespace Simlux\LaravelModelUuid\Uuid;

use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    /**
     * @return string
     */
    public static function generate(): string
    {
        return RamseyUuid::uuid4()->toString();
    }

    /**
     * @param string $uuid
     *
     * @return bool
     */
    public static function checkSyntax(string $uuid): bool
    {
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) === 1;
    }
}