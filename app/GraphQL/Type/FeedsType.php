<?php

namespace App\GraphQL\Type;
use App\Feed;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class FeedsType extends GraphQLType
{
    protected $attributes = [
        'name' => 'FeedsType',
        'description' => 'A Feed type',
        'model' => Feed::class,
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the feed'
            ],
            'message' => [
                'type' => Type::string(),
                'description' => 'The message of the feed'
            ],
            'type' => [
                'type' => Type::string(),
                'description' => 'The type of the feed'
            ],
            'social' => [
                'type' => Type::string(),
                'selectable' => false,
                'description' => 'The social of the feed'
            ],
            'retweet' => [
                'type' => Type::string(),
                'selectable' => false,
                'description' => 'The social of the feed'
            ],
            'parent_id' => [
                'type' => Type::int(),
                'description' => 'The parent of the feed'
            ],
            'user' => [
                'type' => GraphQL::type('user'),
                'description' => 'The user of the feed'
            ]
        ];
    }
}