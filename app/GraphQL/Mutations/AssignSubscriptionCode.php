<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\SubscriptionCodeException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class AssignSubscriptionCode
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // TODO implement the resolver
       /**
        * These code should be implemented in the subscription service
        */
        // dd($args['code']);
        $subscriptionCode = \App\SubscriptionCode::where('code', $args['code'])->whereNull('app_id')->first();
        if (!$subscriptionCode) {
            throw new SubscriptionCodeException("Subscription code cannot be found", 404);
        }
        $subscriptionCode->app_id = $args['app_id'];
        $subscriptionCode->save();
        
        return $subscriptionCode;
    }
}
