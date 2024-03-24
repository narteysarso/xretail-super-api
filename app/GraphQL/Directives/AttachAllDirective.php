<?php

namespace App\GraphQL\Directives;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldResolver;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Mockery\Exception;
use App\Exceptions\ProductException;
use Illuminate\Support\Arr;

class AttachAllDirective extends BaseDirective implements FieldResolver
{
    /**
     * Name of the directive.
     *
     * @return string
     */
    public function name(): string
    {
        return 'attachAll';
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
                $excepts = $this->directiveArgValue("excepts", []);

                if (empty($relation) ||  empty($relationKey))
                    throw new Exception("relation and relation key cannot be null");


                //if model key is not specified then create model before attaching
                //else just attach to model
                if (!array_key_exists($key, $args)) {
                    $modelData = Arr::except($args, [$relation]);
                    $model = $modelClass::create($modelData);
                } else {
                    $model = $modelClass::where($key, $args[$key])->first();
                }

                // dd($args["products"]);
                // dd($model);
                $newArgs = [];
                foreach ($args[$relation] as $key => $rel) {
                    $rel['app_id'] = $args['app_id'];
                    $rel['staff_id'] = $args['staff_id'];
                    $newArgs[$rel[$relationKey]] = $rel;
                }

                if (!$model)
                    throw new Exception("Invoice Error", "Invalid invoice");

                $model->$relation()->detach($newArgs);
                $model->$relation()->attach($newArgs);

                return $model;
            }
        );
    }
}
