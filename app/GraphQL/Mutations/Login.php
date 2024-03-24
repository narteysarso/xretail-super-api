<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\AppException;
use GraphQL\Type\Definition\ResolveInfo;
use Joselfonseca\LighthouseGraphQLPassport\GraphQL\Mutations\BaseAuthResolver;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Login extends BaseAuthResolver
{
    /**
     * @param $rootValue
     * @param array $args
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext|null $context
     * @param \GraphQL\Type\Definition\ResolveInfo $resolveInfo
     * @return array
     * @throws \Exception
     */
    public function resolve($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        try {
            $credentials = $this->buildCredentials($args);
            $guard = $args['data']['customProvider'] ?? "api";

            $provider = config("auth.guards.{$guard}.provider");

            // dd($credentials);
            $response = $this->makeRequest($credentials);
            // dd($response);
            $model = app(config("auth.providers.{$provider}.model"));

            $user = $model->where(config('lighthouse-graphql-passport.username'), $args['data']['username'])->firstOrFail();
            
            $response['user'] = $user;
            return $response;
        } catch (\Throwable $th) {
            throw new AppException($th->getMessage(), "");
        }
        
    }
}


