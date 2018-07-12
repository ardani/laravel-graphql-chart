<?php

namespace App\GraphQL\Type;

use App\Timeline;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TimelinesType extends GraphQLType
{
    protected $attributes = [
        'name' => 'TimelinesType',
        'description' => 'A type of timeline',
        'model' => Timeline::class,
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the timeline'
            ],
            'feed_count' => [
                'type' => Type::int(),
                'description' => 'The feed count of the timeline'
            ],
            'feed_retweet_count' => [
                'type' => Type::int(),
                'description' => 'The feed retweet count of the timeline'
            ],
            'social' => [
                'type' => Type::string(),
                'description' => 'The social of the timeline',
                'selectable' => false
            ],
            'date' => [
                'type' => Type::string(),
                'description' => 'The date of the timeline'
            ]
        ];
    }
}