<?php

namespace App\Http\Resources;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Schema;

abstract class AbstractResource extends JsonResource
{
    /**
     * @var Model
     */
    protected abstract static function model();
    protected abstract static function attribsSearch(): array;

    /**
     * Create new anonymous resource collection.
     *
     * @param  mixed  $resource
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collectionRequest(Request $request)
    {
        $query = self::query($request);

        $resource = $query->paginate($request->input('per_page', 15));
        return self::collection($resource->withQueryString());
    }

    protected static function query(Request $request)
    {
        $model = static::model();
        $table_name = (new $model)->getTable();
        $attribs = Schema::getColumnListing((new $model)->getTable());
        $attribsSearch = static::attribsSearch();
        $casts = (new $model)->getCasts();

        $query = $model::query();
        $query->select($table_name . ".*");

        if ($request->has('q') && trim($request->input('q'))) {
            $search = '%' . $request->input('q') . '%';
            $query->where(function ($query) use ($search, $attribsSearch) {
                foreach ($attribsSearch as $attribSearch) {
                    $query->orWhere($attribSearch, 'like', $search);
                }
            });
        }

        /**
         * Apply the conditions in the query according to the parameters established in the request
         */
        $query = self::setSearchAttributesTable($query, $request, $model, true);
        self::setScopes($query, $request);

        if ($request->has('orderBy')) {
            if ($request->input('orderBy') == 'rand') {
                $query->inRandomOrder();
            } else {
                $sort = strtolower($request->input('sortBy', 'asc'));
                $order = $request->input('orderBy');

                if (!substr_count(".", $order)) {
                    $order = $table_name . "." . $order;
                }

                $query->reorder($order, $sort);
            }
        }

        return $query;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    protected function setScopes(Builder $query, $request)
    {
        $scopes = static::scopes();
        if (count($scopes)) {
            foreach ($scopes as $class_name => $method) {
                $query->{$method}();
                $query = self::setSearchAttributesTable($query, $request, $class_name);
            }
        }
        return $query;
    }

    public static function scopes()
    {
        return [];
    }

    public static function isJoined($query, $table)
    {
        $joins = collect($query->getQuery()->joins);
        return $joins->pluck('table')->contains($table);
    }

    public static function getQueryWithBindings($query): string
    {
        $addSlashes = str_replace('?', "'?'", $query->toSql());
        return vsprintf(str_replace('?', '%s', $addSlashes), $query->getBindings());
    }

    protected static function setSearchAttributesTable(Builder $query, Request $request, $class_name, $is_default = false)
    {
        $table_name = (new $class_name)->getTable();
        $attribs = Schema::getColumnListing($table_name);
        $casts = (new $class_name)->getCasts();

        foreach ($request->all() as $key => $value) {
            if (!substr_count($key, "_") && !$is_default) {
                continue;
            } else if (!substr_count($key, "_") && $is_default) {
                $info_key[0] = $table_name;
                $info_key[1] = $key;
            } else {
                $info_key = explode('_', $key);
                if ($info_key[0] != $table_name) {
                    continue;
                }
            }
            $column = $info_key[1];


            if (in_array($column, $attribs)) {
                $attribsTypes = "";
                try {
                    $attribsTypes = $casts[$column];
                } catch (Exception $e) {
                    //ignore
                }

                switch ($attribsTypes) {
                    case 'bigint';
                    case 'int';
                    case 'integer';
                        $query->where($table_name . "." . $column, 'like', $value);
                        break;
                    default:
                        $query->where($table_name . "." . $column, 'like', '%' . $value . '%');
                        break;
                }
            }
        }

        return $query;
    }
}
