<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\FinancesController;

class ArtisanController extends Controller
{
    public function getCache()
    {
        Artisan::call('route:cache');

        Artisan::call('config:cache');

        Artisan::call('view:cache');

        Artisan::call('optimize');

        return redirect('/dashboard');
    }

    public function bustCache()
    {
        Artisan::call('route:clear');

        Artisan::call('config:clear');

        Artisan::call('view:clear');

        Artisan::call('optimize:clear');

        $this->getCache();

        return redirect('/dashboard');
    }

    public function resetDB()
    {
        set_time_limit(0);
        
        Artisan::call('migrate:refresh');

        return Inertia::render('Auth/Register');
    }

    public function backupDB()
    {
        Artisan::call('database:backup');
    }

    public function filesbackupDB()
    {
        Artisan::call('zip:files');
    }
}
