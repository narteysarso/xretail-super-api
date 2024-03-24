<?php

namespace App\GraphQL\Directives;

use App\Concerns\DataProtect;
use Carbon\Carbon;
use Closure;
use Core\Domain\Factory\SubscriptionFactroy;
use Core\Domain\Service\Subscription;
use Illuminate\Support\Arr;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;


class CreateSubscriptionCodeUseCaseDirective extends BaseDirective implements FieldMiddleware
{
    use DataProtect;
    /**
     * Name of the directive.
     *
     * @return string
     */
    public function name(): string
    {
        return 'createSubscriptionCodeUseCase';
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
                   
                    $subscriptionfactory = new SubscriptionFactroy();
                    $createService = new Subscription($subscriptionfactory);
                    $args = array_merge($args,$createService->createSubscription($args));
                    
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
