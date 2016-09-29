<?php

namespace Rnblog;

use Model_Gallery;
use Orm\Model;
use Pagination;
use Rnblog\Model\Category;
use Rnblog\Model\Post;

class Rnblog_Rodasnet  extends Rnblog_Driver
{
    /**
     * Driver specific functions
     *
     * /


    /**
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

    public function showArticleCount()
    {
        return Post::count();
    }

    /**
     * WARNING php 7 syntax!
     * @param Model $article
     * @return Category | null
     */
    public function getArticleSection( Model $article)
    {
        return Category::query()->select('name')->where('id', $article->category_id)->get_one();
    }

    /**
     * WARNING php 7 syntax!
     * @param string $slug
     * @return \Orm\Model
     */
    public function articleBySlug( string $slug )
    {
        return Post::query()->where('slug', $slug)->related('author')->get_one();
    }

    public function showArticlesRelated( Model $article )
    {
        $category = Category::query()->where('id', $article->category_id)->get_one();

        if ( ! $category)
        {
            return null;
        }
        else
        {
            return Post::query()->where('slug', '!=', $article->slug)
                ->rows_limit(3)
                ->related('category')
                ->where('category.parent_id',  $category->parent_id)
                ->or_where('category.id',  $category->parent_id)->get();
        }
    }

    public function showCategoriesRelated( Model $article )
    {
        $category = Category::query()->where('id', $article->category_id)->get_one();

        if ( ! $category)
        {
            return false;
        }
        else
        {
            return Category::query()
                ->where('parent_id',  $category->parent_id)
                ->or_where('id',  $category->parent_id)->get();
        }
    }

    public function showMoreNews( Model $article )
    {
        // Pagination
        $config = array(
            'pagination_url' => \Uri::current(),
            'total_items'    => Post::count(),
            'per_page'       => 3,
            'uri_segment'    => 'page',
        );
        $pagination = Pagination::forge('more_news_pagination', $config);
        // Get posts
        return Post::query()
            ->offset($pagination->offset)
            ->limit($pagination->per_page)
            ->order_by('created_at', 'DESC')
            ->get();
    }

    public function showFeaturedArticle()
    {
        return Post::query()->where('id', 25)->get_one();
    }

    public function showFeaturedImageEncodedBase64( Model $article )
    {
        if ( $post = Post::query()->where('slug', $article->slug)->get_one() )
        {
            $gallery = Model_Gallery::query()->where('post_id', $post->id)->get_one();
            $data['url'] = $gallery->asset->uri . '' . $gallery->asset->name;
            $data['extension'] = $gallery->asset->type;
            return \Request::forge('image/encoder/encodeBase64')
                    ->execute($data)->response()->body();
        }

        return false;
    }


}
