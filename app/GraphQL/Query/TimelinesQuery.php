<?php

namespace App\GraphQL\Query;

use App\Timeline;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class TimelinesQuery extends Query
{
    protected $attributes = [
        'name' => 'TimelinesQuery',
        'description' => 'Show timelines data (type 1 is facebook , type 2 is twitter)'
    ];

    public function type()
    {
        return GraphQL::paginate('timelines');

    }

    public function args()
    {
        return [
            'type' => [
                'name' => 'type',
                'type' => Type::int()
            ],
            'start_at' => [
                'name' => 'start_at',
                'type' => Type::string()
            ],
            'end_at' => [
                'name' => 'end_at',
                'type' => Type::string()
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

        $where = function ($query) use ($args) {
            if (isset($args['type'])) {
                $query->where('type',$args['type']);
            }

            if (isset($args['start_at'])) {
                $query->where('date', '>=', $args['start_at']);
            }

            if (isset($args['end_at'])) {
                $query->where('date', '<=', $args['end_at']);
            }
        };

        return Timeline::select($select)
            ->where($where)
            ->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}