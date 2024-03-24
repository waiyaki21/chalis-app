<?php

namespace App\Providers;

use Inertia\Inertia;
use App\Models\Setting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share([
            'errors' => function () {
                return Session::get('errors');
            },
            'urlPrev'	=> function() {
                if (url()->previous() !== route('login') && url()->previous() !== '' && url()->previous() !== url()->current()) {
		    		return url()->previous();
		    	}else {
		    		return 'empty';
		    	}
		    },
        ]);
        
        //pass to the side nav
        view()->composer(
            ['partials.navs.side-nav', 'partials.navs.main-nav'],
            function ($view) {
                // get the settings 
                $view->with('setting', Setting::orderBy('id', 'desc')->first());
            }
        );
    }
}
