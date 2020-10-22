<?php

namespace Voice\ExternalRelations\App;

use Voice\ExternalRelations\App\Interfaces\ResolverInterface;

class RelationServiceResolver
{
       public static function getResolver(string $type): ?ResolverInterface
    {
        $resolverClass = isset(config("asseco-external-relations.resolvers")[$type]) ? config("asseco-external-relations.resolvers")[$type] : null;
        return $resolverClass ? new $resolverClass() : null;
    }
}
