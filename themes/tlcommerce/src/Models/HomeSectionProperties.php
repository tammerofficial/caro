<?php

namespace Theme\TLCommerce\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSectionProperties extends Model
{
    protected $fillable = ['section_id', 'key_name'];

    protected $table = "tl_theme_tlcommerce_home_page_sections_properties";
}
