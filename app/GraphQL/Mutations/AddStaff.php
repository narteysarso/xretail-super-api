<?php

namespace App\GraphQL\Mutations;


use App\Utility\Password;
use App\Events\NewStaffRegistered;
use Illuminate\Support\Facades\Hash;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class AddStaff
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
        $password = isset($args['password']) ?
            $args['password'] : Password::make();
        $args['password'] = Hash::make($password);
        $app = $context->user()->app;
        // dd($args);

        $staff = \App\Staff::create($args);
        if (isset($args["role"])) {
            $staff->roles()->detach();
            $staff->roles()->attach($args["role"], ["app_id" => $app->id]);
        }
        if ($staff) {

            // event(new NewStaffRegistered($context->user, $staff, $password));
        }
        return $staff;
    }
}
