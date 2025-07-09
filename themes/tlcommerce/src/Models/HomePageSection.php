<?php

namespace Theme\TLCommerce\Models;

use Illuminate\Database\Eloquent\Model;
use Theme\TLCommerce\Models\HomeSectionProperties;

class HomePageSection extends Model
{

    protected $table = "tl_theme_tlcommerce_home_page_sections";

    public function section_properties()
    {
        return $this->hasMany(HomeSectionProperties::class, 'section_id', 'id');
    }
}
