<?php

namespace App\GraphQL\Directives;

use Closure;
use Illuminate\Support\Arr;
use App\Exceptions\AppException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;

class VerifyMeDirective extends BaseDirective implements FieldMiddleware
{
    /**
     * Name of the directive.
     *
     * @return string
     */
    public function name(): string
    {
        return 'verifyMe';
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

        // dd($value->getField());
        return $next(
            $value->setResolver(
                function ($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) use ($previousResolver, $value) {

                    //Verify if user owns this app by finding it in his apps
                    $app = $context->user->apps()->where("id", $args['id'])->where("user_id", $context->user->id)->first();

                    if (!$app)
                        throw new AppException("app access denied", "App with id {$args['id']} for user {$context->user->id} not found");

                    return $previousResolver(
                        $rootValue,
                        $args,
                        $context,
                        $resolveInfo
                    );
                }
            )
        );
    }
}
