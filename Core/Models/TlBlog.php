<?php

namespace Core\Models;


use Core\Models\User;
use Core\Models\TlBlogComment;
use Core\Models\TlBlogTranslation;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;

use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class TlBlog extends Model implements Sitemapable
{
    protected $guarded = [];

    public function translation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $blog_translations = $this->blog_translations->where('lang', $lang)->first();
        return $blog_translations != null ? $blog_translations->$field : $this->$field;
    }

    // A Blog Has Many Translations
    public function blog_translations()
    {
        return $this->hasMany(TlBlogTranslation::class, 'blog_id');
    }

    // A Blog Belongs to One User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // A Blog Has Many Comments
    public function allblogComment()
    {
        return $this->hasMany(TlBlogComment::class, 'blog_id')->where('status', config('settings.blog_comment_status.approve'));
    }

    //Blog category relation
    public function categories()
    {
        return $this->belongsToMany(TlBlogCategory::class, 'tl_blogs_categories', 'blog_id', 'category_id');
    }

    // Blog Sitemap Url Create
    public function toSitemapTag(): Url | string | array
    {
        return Url::create('/blog' . '/' . $this->permalink)
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setPriority(0.1);
    }
}
