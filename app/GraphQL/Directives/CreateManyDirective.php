<?php

namespace App\GraphQL\Directives;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldResolver;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Mockery\Exception;
use App\Exceptions\ProductException;

class CreateManyDirective extends BaseDirective implements FieldResolver
{
    /**
     * Name of the directive.
     *
     * @return string
     */
    public function name(): string
    {
        return 'createMany';
    }

    /**
     * Resolve the field directive.
     *
     * @param  \Nuwave\Lighthouse\Schema\Values\FieldValue  $fieldValue
     * @return \Nuwave\Lighthouse\Schema\Values\FieldValue
     */
    public function resolveField(FieldValue $fieldValue): FieldValue
    {

        return $fieldValue->setResolver(
            function ($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {

                $modelClass = $this->getModelClass();
                $name = $this->directiveArgValue('name');
                $fields = $this->directiveArgValue('fields',[]);
                $relatedFields = [];
                $models = [];
                
                foreach ($fields as $field) {
                    
                    $relatedFields[$field] = $args[$field];
                }

                foreach ($args[$name] as $data) {
                    # code..
                    // dd($data);
                    $fullInsertData = array_merge( $data, $relatedFields);
                    array_push($models, $modelClass::create($fullInsertData));
                }

                return $models;
            }
        );
    }
}
