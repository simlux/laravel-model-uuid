<?php declare(strict_types=1);

namespace Simlux\LaravelModelUuid\Uuid;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait UuidModelTrait
{

    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function bootUuidModelTrait()
    {
        static::creating(function (Model $model) {
            $model->uuid = Uuid::generate();
        });

        static::saving(function (Model $model) {
            $originalUuid = $model->getOriginal('uuid');
            if ($model->uuid !== $originalUuid) {
                $model->uuid = $originalUuid;
            }
        });
    }

    /**
     * Scope a query to only include models matching the supplied UUID.
     * Returns the model by default, or supply a second flag `false` to get the Query Builder instance.
     *
     * @param  Builder $query The Query Builder instance.
     * @param  string  $uuid  The UUID of the model.
     * @param  bool    $first Returns the model by default, or set to `false` to chain for query builder.
     *
     * @throws ModelNotFoundException
     *
     * @return Model|Builder
     */
    public function scopeUuid(Builder $query, string $uuid, bool $first = true)
    {
        if (!is_string($uuid) || !Uuid::checkSyntax($uuid)) {
            throw (new ModelNotFoundException())->setModel(get_class($this));
        }

        $search = $query->where('uuid', $uuid);

        return $first ? $search->firstOrFail() : $search;
    }

    /**
     * Scope a query to only include models matching the supplied ID or UUID.
     * Returns the model by default, or supply a second flag `false` to get the Query Builder instance.
     *
     * @param  Builder $query    The Query Builder instance.
     * @param  string  $idOrUuid The UUID of the model.
     * @param  bool    $first    Returns the model by default, or set to `false` to chain for query builder.
     *
     * @throws ModelNotFoundException
     *
     * @return Model|Builder
     */
    public function scopeIdOrUuId(Builder $query, $idOrUuid, bool $first = true)
    {
        if (!is_string($idOrUuid) && !is_numeric($idOrUuid)) {
            throw (new ModelNotFoundException)->setModel(get_class($this));
        }

        if (!Uuid::checkSyntax($idOrUuid) && preg_match('/^[0-9]+$/', $idOrUuid) !== 1) {
            throw (new ModelNotFoundException)->setModel(get_class($this));
        }

        $search = $query->where(function ($query) use ($idOrUuid) {
            $query->where('id', $idOrUuid)
                ->orWhere('uuid', $idOrUuid);
        });

        return $first ? $search->firstOrFail() : $search;
    }
}