<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Theme;

class ThemeComposers
{
    /**
     * Create a new profile composer.
     */

    public function compose(View $view)
    {
        $footer_left_menu = getMenuPositionId(config('default.menu_position')['footer_left_menu']);
        $footer_left_menu_structure = getMenuStructure($footer_left_menu);
        
        $footer_right_menu = getMenuPositionId(config('default.menu_position')['footer_right_menu']);
        $footer_right_menu_structure = getMenuStructure($footer_right_menu);

        $view->with('footer_left_menu', $footer_left_menu_structure)
            ->with('footer_right_menu', $footer_right_menu_structure);
    }
}
