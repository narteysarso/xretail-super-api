<?php

namespace App\GraphQL\Directives;

use Closure;
use Illuminate\Support\Arr;
use GraphQL\Language\AST\NameNode;
use GraphQL\Language\AST\NodeList;
use GraphQL\Language\AST\DirectiveNode;
use GraphQL\Language\AST\NamedTypeNode;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use GraphQL\Language\AST\InputValueDefinitionNode;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Directives\EqDirective;

class AppDirective extends BaseDirective implements FieldMiddleware
{
    /**
     * Name of the directive.
     *
     * @return string
     */
    public function name(): string
    {
        return 'app';
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

                    $app = $this->getApp(
                        $context,
                        $args['app_token']
                    );


                    $inputValueDefinitionNode = new InputValueDefinitionNode([
                        "name" => new NameNode(["value" => "app_id"]),
                        "type" => new NamedTypeNode([
                            "name" => new NameNode([
                                "value" => "Int"
                            ])
                        ]),
                        "defaultValue" => null,
                        "directives" => new NodeList([
                            new DirectiveNode([
                                "name" => new NameNode([
                                    "value" => "eq"
                                ]),
                                "arguments" => new NodeList([])
                            ])
                        ]),
                        "description" => null
                    ]);

                    $eq = new EqDirective();
                    $eq->definitionNode = $inputValueDefinitionNode;


                    $resolveInfo
                        ->builder
                        ->addBuilderDirective("app_id", $eq);


                    // dd($resolveInfo->builder);
                    return $previousResolver(
                        $rootValue,
                        Arr::add($args, "app_id", $app->id),
                        $context,
                        $resolveInfo
                    );
                }
            )
        );
    }

    public function getApp(GraphQLContext $context, $token)
    {
        return  $context->user->apps()->where("token", $token)->where("user_id", $context->user->id)->first();
    }
}
