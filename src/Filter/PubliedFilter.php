<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use DateTimeImmutable;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;

final class PubliedFilter extends AbstractFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {   
        if ($property !== 'publied') {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];  

        $currentDate = new DateTimeImmutable();
        $comparison_sign = '>=';
        
        if($value === "true") {
            $comparison_sign = '<=';
        }

        $queryBuilder
            ->andWhere(sprintf("%s.publication_date %s '%s'", $rootAlias, $comparison_sign, $currentDate->format('Y-m-d')));
    }
    

    public function getDescription(string $resourceClass): array
    {
        if (!$this->properties) {
            return [];
        }
        $description = [];
        foreach ($this->properties as $property => $strategy) {
            $description["publied"] = [
                'property' => $property,
                'type' => Type::BUILTIN_TYPE_BOOL,
                'required' => true,
                'description' => 'Filter on publication date, if set to true return movies who are publied. If set to false, return movies in coming',
            ];
        }
        return $description;
    }
}