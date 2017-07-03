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

namespace Superman2014\JsonApi\Authorizer;

use Superman2014\JsonApi\Contracts\Authorizer\AuthorizerInterface;
use Superman2014\JsonApi\Contracts\Repositories\ErrorRepositoryInterface;
use Superman2014\JsonApi\Utils\ErrorCreatorTrait;
use Neomerx\JsonApi\Contracts\Encoder\Parameters\EncodingParametersInterface;

/**
 * Class AbstractAuthorizer
 * @package Superman2014\JsonApi
 */
abstract class AbstractAuthorizer implements AuthorizerInterface
{

    use ErrorCreatorTrait;

    /**
     * @var ErrorRepositoryInterface
     */
    private $errorRepository;

    /**
     * AbstractAuthorizer constructor.
     * @param ErrorRepositoryInterface $errorRepository
     */
    public function __construct(ErrorRepositoryInterface $errorRepository)
    {
        $this->errorRepository = $errorRepository;
    }

    /**
     * @inheritdoc
     */
    public function canReadRelatedResource($relationshipKey, $record, EncodingParametersInterface $parameters)
    {
        return $this->canRead($record, $parameters);
    }

    /**
     * @inheritdoc
     */
    public function canReadRelationship($relationshipKey, $record, EncodingParametersInterface $parameters)
    {
        return $this->canReadRelatedResource($relationshipKey, $record, $parameters);
    }

    /**
     * @inheritdoc
     */
    protected function getErrorRepository()
    {
        return $this->errorRepository;
    }

}
