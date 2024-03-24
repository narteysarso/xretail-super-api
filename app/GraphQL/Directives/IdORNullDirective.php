<?php

namespace App\GraphQL\Directives;

use DB;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldResolver;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;


class IdORNullDirective extends BaseDirective implements FieldResolver
{
    /**
     * Name of the directive.
     *
     * @return string
     */
    public function name(): string
    {
        return 'idORNull';
    }

    /**
     * Resolve the field directive.
     *
     * @param  \Nuwave\Lighthouse\Schema\Values\FieldValue  $fieldValue
     * @return \Nuwave\Lighthouse\Schema\Values\FieldValue
     */
    public function resolveField(FieldValue $fieldValue): FieldValue
    {

        // dd($fieldValue->getField());

        return $fieldValue->setResolver(
            function ($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {

                $tableName = $this->definitionNode->name->value; // gets the table name of the fields model
                $keys = $this->directiveArgValue('keys', []); // fetches an array of [foreignkeyColName, primaryKeyColName]
                $foriegnKey = $keys[0]; // stores foreignKeyColName


                //returns a collection of select results
                return DB::table("{$tableName}")->where("{$foriegnKey}", null)->orWhere("{$foriegnKey}", $root->id)->get();
            }
        );
    }
}
