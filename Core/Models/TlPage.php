<?php

namespace Core\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;

use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class TlPage extends Model implements Sitemapable
{
    public $table = 'tl_pages';
    protected $guarded = [];

    public function translation($field = '', $lang = false)
    {
        if ($field == 'name') {
            $translateField = 'title';
            $lang = $lang == false ? App::getLocale() : $lang;
            $page_translations = $this->page_translations->where('lang', $lang)->first();
            return $page_translations != null ? $page_translations->$translateField : $this->$field;
        } else {
            $lang = $lang == false ? App::getLocale() : $lang;
            $page_translations = $this->page_translations->where('lang', $lang)->first();
            return $page_translations != null ? $page_translations->$field : $this->$field;
        }
    }

    // Tag has Many translations
    public function page_translations()
    {
        return $this->hasMany(TlPageTranslation::class, 'page_id');
    }

    // Getting a page Parents title,permalink
    public function parentPage()
    {
        return $this->belongsTo(self::class, 'parent');
    }

    // For all the Active/Publish Child Comment
    public function childs()
    {
        return $this->hasMany(self::class, 'parent')->where('publish_status', config('settings.page_status.publish'))->orderBy('id', 'ASC');
    }

    //page sitemap generation
    public function toSitemapTag(): Url | string | array
    {
        return Url::create('/page' . '/' . $this->permalink)
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setPriority(0.1);
    }
}
