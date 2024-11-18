<?php

namespace App\QueryType;

use Ibexa\Contracts\Core\Repository\Exceptions\InvalidCriterionArgumentException;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Core\QueryType\QueryType;

class CarsQueryType implements QueryType
{
    public static function getName(): string
    {
        return 'Cars';
    }

    /**
     * @throws InvalidCriterionArgumentException
     */
    public function getQuery(array $parameters = []): LocationQuery
    {
        $criteria = [
            new Criterion\Visibility(Criterion\Visibility::VISIBLE),
            new Criterion\ContentTypeIdentifier(['car']),
            new Criterion\Subtree($parameters['location_path'])
        ];
        return new LocationQuery([
            'filter' => new Criterion\LogicalAnd($criteria)
        ]);
    }

    public function getSupportedParameters()
    {
        return [
            'location_path' => 'string', // or the appropriate type depending on the path structure
        ];
    }
}
