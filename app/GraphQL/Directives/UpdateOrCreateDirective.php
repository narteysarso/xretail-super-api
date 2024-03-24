<?php

namespace App\GraphQL\Directives;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldResolver;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;


class UpdateOrCreateDirective extends BaseDirective implements FieldResolver
{
    /**
     * Name of the directive.
     *
     * @return string
     */
    public function name(): string
    {
        return 'updateOrCreate';
    }

    /**
     * Resolve the field directive.
     *
     * @param  \Nuwave\Lighthouse\Schema\Values\FieldValue  $fieldValue
     * @return \Nuwave\Lighthouse\Schema\Values\FieldValue
     */
    public function resolveField(FieldValue $fieldValue): FieldValue
    {
        return $fieldValue->setResolver(
            function ($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {

                $modelClass = $this->getModelClass();
                $key = $this->directiveArgValue("key", "app_id");
                $previous = $modelClass::where($key, $args[$key])->first();

                // dd($previous);
                
                $resolver = $resolveInfo
                    ->builder
                    ->apply($modelClass::query(), $args)
                    ->updateOrCreate($previous ? $previous->toArray() : [], $args);

                return $resolver;
            }
        );
    }
}
