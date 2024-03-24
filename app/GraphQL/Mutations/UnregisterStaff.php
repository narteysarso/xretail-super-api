<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class UnregisterStaff
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
        $app = $this->getApp($context,$args['app_token']);

        $args['app_id'] = $app->id;

        $staff = \App\Staff::find($args['id']);
        if ($staff) {
            $staff->delete();
            // $staff->forceDelete();
        }
        return $staff;
    }

    public function getApp(GraphQLContext $context, $token)
    {
        return  $context->user->apps()->where("token", $token)->where("user_id", $context->user->id)->first();
    }
}
