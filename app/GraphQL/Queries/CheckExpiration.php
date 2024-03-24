<?php

namespace App\GraphQL\Queries;

use Core\Domain\Entity\App;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Concerns\DataProtect;
use App\Exceptions\AppException;
use DateTime;

class CheckExpiration
{
    use DataProtect;
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
        try {
            //code...
            dd(new DateTime($this->decrypt($context->user->app->expires_in)));
            $date = App::verifyAppExpiryDate(new DateTime($this->decrypt($context->user->app->expires_in)));
            return ['expires' => $date->format('Y-m-d H:i:s')];
        } catch (\Throwable $th) {
            //throw $th;
            throw new AppException($th->getMessage(),"");
        }
        
    }
}

//LrA4Bf1nCrWSOQ==
