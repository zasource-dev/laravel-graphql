<?php

namespace App\GraphQL\Mutations;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ArticleMutator
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
    public function create($rootValue, array $args, GraphQLContext $context)
    {
        $article = new \App\Article($args);
        $context->user()->articles()->save($article);

        return $article;
    }

    public function resolveAddComment($rootValue, array $args, GraphQLContext $context)
    {
        $article = \App\Article::find($args["comment"]["articleId"]);
        $comment = new \App\Comment([
            "text" => $args["comment"]["text"]
        ]);
        $comment->user()->associate($context->user());
        $article->comments()->save($comment);

        return $comment;
    }
}
