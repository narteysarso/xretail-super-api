<?php

namespace App\GraphQL\Directives;

use Closure;
use App\Concerns\DataProtect;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use App\Exceptions\AppException;
use Exception;


class RenewSubscriptionDirective extends BaseDirective implements FieldMiddleware
{
    use DataProtect;
    /**
     * Name of the directive.
     *
     * @return string
     */
    public function name(): string
    {
        return 'renewSubscription';
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
                    try {
                        //code...
                        $key = $this->directiveArgValue('key', "expires_in");
                        
                        $crypt = null;
                        //validate code with external api
                        // dd($args);
                        $days = 12; //days from external api
                        if($args['code'] === 'just for testing'){
                            $expires_in = (Carbon::now())->add($days, 'days');
                            $crypt = $this->encrypt($expires_in->toDateString());
                            // return ["message" => "renewal successful", "expires" => "2020-12-10"];
                            return $previousResolver(
                                $rootValue,
                                    Arr::add($args, $key, $crypt),
                                    $context,
                                    $resolveInfo
                                );
                        }
                        throw new Exception("Invalid subscription codes");
                    } catch (\Throwable $th) {
                        throw new AppException($th->getMessage(),"");
                    }
                    
                }
            )
        );
    }
}

