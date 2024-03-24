<?php

namespace App\GraphQL\Directives;

use DB;
use Mockery\Exception;
use App\Exceptions\StaffException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldResolver;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;

class DetachDirective extends BaseDirective implements FieldResolver
{
    /**
     * Name of the directive.
     *
     * @return string
     */
    public function name(): string
    {
        return 'detach';
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
                $key = $this->directiveArgValue('key', 'id');
                $relation = $this->directiveArgValue('relation');
                $relationKey = $this->directiveArgValue('relationKey');

                // dd($newArgs);
                if (empty($relation) ||  empty($relationKey))
                    throw new Exception("relation and relation key cannot be null");

                $model = $modelClass::where($key, $args["staff_id"])->first();

                if (!$model)
                    throw new StaffException("Staff Error", "staff not found");

                $model->$relation()->detach($args[$relationKey]);

                return $model;
            }
        );
    }
}
