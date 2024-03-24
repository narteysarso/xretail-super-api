<?php

namespace App\GraphQL\Directives;

use Closure;
use Illuminate\Support\Arr;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;


class ActivateStaffDirective extends BaseDirective implements FieldMiddleware
{
    /**
     * Name of the directive.
     *
     * @return string
     */
    public function name(): string
    {
        return 'activateStaff';
    }

    /**
     * Resolve the field directive.
     *
     * @param  \Nuwave\Lighthouse\Schema\Values\FieldValue  $value
     * @param  \Closure  $next
     * @return \Nuwave\Lighthouse\Schema\Values\FieldValue
     *
     * @throws \Nuwave\Lighthouse\Exceptions\DirectiveException
     */
    public function handleField(FieldValue $value, Closure $next): FieldValue
    {

        $previousResolver = $value->getResolver();

        return $next(
            $value->setResolver(
                function ($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) use ($previousResolver) {
                    $key = $this->directiveArgValue('key', "is_active");
                    return $previousResolver(
                        $rootValue,
                        Arr::add($args, $key, 1),
                        $context,
                        $resolveInfo
                    );
                }
            )
        );
    }
}
