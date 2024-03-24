<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ChangeEquityCashValidity
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
        $record = \App\Cashbook::where('id',$args['id'])->first();
        
        if(!$record)
            throw new \Exception("Equity cash record not found");
        
        if($record->is_void)
            throw new \Exception("Equity cash record is already void.");
        // dd($record);
        $args['credit'] = $record->debit;
        
        $cashbook = \App\Cashbook::create([
            "description" => $args["description"],
            "credit" => $args["credit"],
            "app_id" => $args['app_id']
            ]); 
        if(!$cashbook)
            throw new \Exception("Unable to invalidate cash equity", 1);
        
        $record->is_void = $args['is_void'];
        $record->save();
            
        return $cashbook;
    }
}
