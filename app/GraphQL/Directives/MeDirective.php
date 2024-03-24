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
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Schema\Directives\EqDirective;

class MeDirective extends BaseDirective implements FieldMiddleware
{
    /**
     * Name of the directive.
     *
     * @return string
     */
    public function name(): string
    {
        return 'me';
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
                    $key = $this->directiveArgValue("key", "user_id");

                    $inputValueDefinitionNode = new InputValueDefinitionNode([
                        "name" => new NameNode(["value" => $key]),
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
                        ->addBuilderDirective($key, $eq);

                    return $previousResolver(
                        $rootValue,
                        Arr::add($args, $key, $context->user->id),
                        $context,
                        $resolveInfo
                    );
                }
            )
        );
    }
}
