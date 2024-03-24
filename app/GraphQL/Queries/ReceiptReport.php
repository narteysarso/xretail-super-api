<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\Hash;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ReceiptReport
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
        // dd($args);

        try {
            
            $query = \DB::table('receipts')
            ->selectRaw('SUM(amount) as amount')
            ->selectRaw('receipt_type.name as receipt')
            ->selectRaw("Date(receipts.created_at) as date")
            ->join('receipt_type', 'receipt_type.id', '=', 'receipttype_id')
            ->where('is_void',$args['is_void'])
            ->where('app_id', $args['app_id']);

            if(array_key_exists('created_at',$args) ){
                // dd($args['created_at']);
                $query->whereBetween('receipts.created_at', [$args['created_at']['from'], $args['created_at']['to']]);
            }
            $result = $query
            ->groupBy(array_merge($args['groupByArg'], ["date"]))
            ->orderBy('date', $args['orderBy'][0]['order'])
            ->get();
            // dd($result);
            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
}
