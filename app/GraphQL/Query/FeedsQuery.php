<?php

namespace App\GraphQL\Query;

use App\Feed;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class FeedsQuery extends Query
{
    protected $attributes = [
        'name' => 'FeedsQuery',
        'description' => 'Show feeds data (type 1 is facebook , type 2 is twitter)'
    ];

    public function type()
    {
        return GraphQL::paginate('feeds');
    }

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int()
            ],
            'type' => [
                'name' => 'type',
                'type' => Type::int()
            ],
            'retweet' => [
                'name' => 'retweet',
                'type' => Type::boolean()
            ],
            'limit' => [
                'name' => 'limit',
                'type' => Type::INT(),
            ],
            'page' => [
                'name'=> 'page',
                'type'=>Type::INT()
            ]
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();
        $where = function ($query) use ($args) {
            if (isset($args['id'])) {
                $query->where('id',$args['id']);
            }
            if (isset($args['type'])) {
                $query->where('type',$args['type']);
            }
            if (isset($args['retweet'])) {
                $query->where('parent_id', '>', 0);
            }
        };

        return Feed::select($select)->with($with)
            ->where($where)
            ->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}