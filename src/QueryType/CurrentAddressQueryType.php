<?php

namespace App\QueryType;

use Ibexa\Contracts\Core\Repository\Exceptions\InvalidCriterionArgumentException;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Core\QueryType\QueryType;

class CurrentAddressQueryType implements QueryType
{
    public static function getName(): string
    {
        return 'CurrentAddress';
    }

    /**
     * @throws InvalidCriterionArgumentException
     */
    public function getQuery(array $parameters = []): LocationQuery
    {
        return new LocationQuery([
            'filter' => new Criterion\LogicalAnd(
                [
                    new Criterion\Visibility(Criterion\Visibility::VISIBLE),
                    new Criterion\ContentTypeIdentifier(['car_dealership']),
                    new Criterion\Ancestor($parameters['location_path'])
                ]
            )
        ]);
    }

    public function getSupportedParameters()
    {
        return [
            'location_path' => 'string', // or the appropriate type depending on the path structure
        ];
    }
}
