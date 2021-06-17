<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Services\SidebarService;

class SidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $sidebar = (new SidebarService())->get_sidebar();
        
        $view->with('admin_menu', $sidebar['admin_menu']);
        $view->with('user_menu', $sidebar['user_menu']);
    }
}