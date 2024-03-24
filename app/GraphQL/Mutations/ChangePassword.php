<?php

namespace App\GraphQL\Mutations;

use App\Staff;
use Mockery\Exception;
use Illuminate\Support\Facades\Hash;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Joselfonseca\LighthouseGraphQLPassport\GraphQL\Mutations\BaseAuthResolver;

class ChangePassword extends BaseAuthResolver
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
        $credentials = $this->buildCredentials($args);
        $provider = config("auth.guards.staff.provider");
        $response = $this->makeRequest($credentials);


        if ($response['token_type'] === "Bearer") {
            $provider = config("auth.guards.staff.provider");
            $model = app(config("auth.providers.{$provider}.model"));
            $user = $model->where(config('lighthouse-graphql-passport.username'), $args['data']['username'])->firstOrFail();
            if ($user) {
                $user->update(["password" => Hash::make($args['data']['new_password'])]);
                return $user;
            }
        }

        throw new Exception("Unidentified user. Credentials may be wrong.", 1);
    }
}
