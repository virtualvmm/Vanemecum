<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\ContactoMensaje;
use Illuminate\Support\Facades\Auth;

class NavigationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $unreadCount = 0;
        
        if (Auth::check() && Auth::user()->hasRole('Admin')) {
            $unreadCount = ContactoMensaje::where('leido', false)->count();
        }
        
        $view->with('unreadMessagesCount', $unreadCount);
    }
}

