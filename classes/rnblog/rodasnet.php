<?php

namespace Rnblog;

use Model_Gallery;
use Orm\Model;
use Pagination;
use Rnblog\Model\Category;
use Rnblog\Model\Post;

class Rnblog_Rodasnet extends Rnblog_Driver
{
    /**
     * Driver specific functions
     *
     * /
     *
     *
     * /**
     * @param Pagination $pagination
     * @return array
     * @internal param $offset
     * @internal param $per_page
     */

    public function showArticlesPaginated(Pagination $pagination)
    {
        return Post::query()
            ->offset($pagination->offset)
            ->limit($pagination->per_page)
            ->order_by('created_at', 'DESC')
            ->get();
    }

    /**
     * @return int
     */
    public function ArticleCount()
    {
        return Post::count();
    }

    /**
     * WARNING php 7 syntax!
     * @param Model $article
     * @return Category | null
     */
    public function getArticleSection(Model $article)
    {
        return Category::query()->select('name')->where('id', $article->category_id)->get_one();
    }

    /**
     * WARNING php 7 syntax!
     * @param string $slug
     * @return \Orm\Model
     */
    public function articleBySlug(string $slug)
    {
        return Post::query()->where('slug', $slug)->related('author')->get_one();
    }

    public function showArticlesRelated(Model $article)
    {
        $category = Category::query()->where('id', $article->category_id)->get_one();

        if (!$category) {
            return null;
        } else {
            return Post::query()->where('slug', '!=', $article->slug)
                ->rows_limit(3)
                ->related('category')
                ->where('category.parent_id', $category->parent_id)
                ->or_where('category.id', $category->parent_id)->get();
        }
    }

    public function showCategoriesRelated(Model $article)
    {
        $category = Category::query()->where('id', $article->category_id)->get_one();

        if (!$category) {
            return false;
        } else {
            return Category::query()
                ->where('parent_id', $category->parent_id)
                ->or_where('id', $category->parent_id)->get();
        }
    }

    public function showMoreNews(Model $article)
    {
        $postRandom = rand(0, Post::count());
        return Post::query()
            ->offset(Post::count() - $postRandom)
            ->limit(5)
            ->where('category_id', '!=', $article->category_id)
            ->order_by('created_at', 'DESC')
            ->get();
    }

    public function showFeaturedArticle()
    {
        // TODO Add Featured post model.
        // TODO Find post that matches month and day
        // SELECT * FROM `users` WHERE `email` LIKE "%@example.com" LIMIT 5 OFFSET 10
//        $users = Model_User::find_by('email', '%@example.com', 'like', 5, 10);

        // Or.. http://www.richardlord.net/blog/dates-in-php-and-mysql

//        $query = "UPDATE table SET
//    datetimefield = FROM_UNIXTIME($phpdate)
//    WHERE...";
//        $query = "SELECT UNIX_TIMESTAMP(datetimefield)
//    FROM table WHERE...";

        // Thu Sep 29 18:55:57 2016
//        $timestamp = \Date::forge();

//        $post = Post::find_by('created_at', '%@example.com', 'like', 5, 10);

//        ->where('created_at', $FeaturedId )->get_one()

        if (!$post = null)
        {
            $FeaturedId = $this->computeFeaturedId(date('z'));

            if (!$post = Post::query()->where('id', $FeaturedId)->get_one())
            {
                return Post::query()->where('id', 25)->get_one();
            }
        }

        return $post;
    }

    public function showFeaturedImageEncodedBase64(Model $article)
    {
        if ($post = Post::query()->where('slug', $article->slug)->get_one())
        {
            if ($gallery = Model_Gallery::query()->where('post_id', $post->id)->get_one())
            {
                $data['url'] = $gallery->asset->uri . '' . $gallery->asset->name;
                $data['extension'] = $gallery->asset->type;
                return \Request::forge('image/encoder/encodeBase64')
                    ->execute($data)->response()->body();
            }
        }

        return false;
    }

    protected function computeFeaturedId($FeaturedId)
    {
        if (Post::count() < $FeaturedId)
        {
            return $FeaturedId = abs(round($FeaturedId / 2));
        }

        return $FeaturedId;
    }

}
