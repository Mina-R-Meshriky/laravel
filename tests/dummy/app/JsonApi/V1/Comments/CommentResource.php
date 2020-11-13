<?php
/**
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

namespace App\JsonApi\V1\Comments;

use LaravelJsonApi\Core\Resources\JsonApiResource;
use function url;

class CommentResource extends JsonApiResource
{

    /**
     * @return string
     */
    public function type(): string
    {
        return 'comments';
    }

    /**
     * @return string
     */
    public function selfUrl(): string
    {
        return url('api/v1', [$this->type(), $this->id()]);
    }

    /**
     * @return iterable
     */
    public function attributes(): iterable
    {
        return [
            'content' => $this->content,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }

    /**
     * @return iterable
     */
    public function relationships(): iterable
    {
        return [
            $this->relation('post'),
            $this->relation('user'),
        ];
    }

}