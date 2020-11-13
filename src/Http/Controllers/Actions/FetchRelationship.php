<?php
/*
 * Copyright 2020 Cloud Creativity Limited
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

declare(strict_types=1);

namespace LaravelJsonApi\Http\Controllers\Actions;

use Illuminate\Contracts\Support\Responsable;
use LaravelJsonApi\Contracts\Routing\Route;
use LaravelJsonApi\Contracts\Store\Store as StoreContract;
use LaravelJsonApi\Core\Responses\RelationshipResponse;
use LaravelJsonApi\Http\Requests\ResourceQuery;

trait FetchRelationship
{

    /**
     * Fetch the resource identifier(s) for a JSON API relationship.
     *
     * @param Route $route
     * @param StoreContract $store
     * @return Responsable
     */
    public function readRelationship(Route $route, StoreContract $store): Responsable
    {
        $model = $route->model();
        $relation = $route->schema()->relationship(
            $route->relationship()
        );

        if ($relation->toOne()) {
            $request = ResourceQuery::queryOne($relation->inverse());
            $data = $store->queryToOne(
                $route->resourceType(),
                $model,
                $relation->name()
            )->using($request)->first();
        } else {
            $request = ResourceQuery::queryMany($relation->inverse());
            $data = $store->queryToMany(
                $route->resourceType(),
                $model,
                $relation->name()
            )->using($request)->getOrPaginate($request->page());
        }

        return new RelationshipResponse(
            $model,
            $relation->name(),
            $data
        );
    }
}