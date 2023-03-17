<?php

namespace App\Http\Resources;

use Exception;
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

        foreach ($request->all() as $key => $value) {

            if (in_array($key, $attribs)) {
                $attribsTypes = "";
                if (!substr_count($key, ".")) {
                    try {
                        if (isset($casts[$key])) {
                            $attribsTypes = $casts[$key];
                        } else {
                            $attribsTypes = Schema::getColumnType($table_name, $key);
                        }
                    } catch (Exception $e) {
                        //ignore
                    }
                }

                $key = $table_name . "." . $key;
                switch ($attribsTypes) {
                    case 'bigint';
                    case 'int';
                    case 'integer';
                        $query->where($key, 'like', $value);
                        break;
                    default:
                        $query->where($key, 'like', '%' . $value . '%');
                        break;
                }
            }
        }

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
}
