<?php

/**
 * Copyright 2016 Cloud Creativity Limited
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

namespace Superman2014\JsonApi\Validators;

use Superman2014\JsonApi\Contracts\Object\ResourceIdentifierInterface;
use Superman2014\JsonApi\Contracts\Object\ResourceInterface;
use Superman2014\JsonApi\Contracts\Validators\AcceptRelatedResourceInterface;
use Superman2014\JsonApi\Object\ResourceIdentifier;

/**
 * Class AcceptImmutableRelationship
 * @package Superman2014\JsonApi
 */
class AcceptImmutableRelationship implements AcceptRelatedResourceInterface
{

    /**
     * @var ResourceIdentifier|null
     */
    private $current;

    /**
     * AcceptImmutableRelationship constructor.
     * @param string $type
     * @param string|int|null $id
     */
    public function __construct($type, $id = null)
    {
        if ($type && $id) {
            $this->current = ResourceIdentifier::create($type, $id);
        }
    }

    /**
     * @inheritdoc
     */
    public function accept(
        ResourceIdentifierInterface $identifier,
        $record = null,
        $key = null,
        ResourceInterface $resource = null
    ) {
        if (!$this->current) {
            return true;
        }

        return $this->current->getType() == $identifier->getType() &&
            $this->current->getId() == $identifier->getId();
    }

}
