<?php

namespace App\Providers;

use App\Models\Feedback;
use App\Models\FeedbackProposal;
use App\Models\Komentar;
use App\Models\Peringatan;
use App\Models\PeringatanLpj;
use App\Models\PeringatanProposal;
use Carbon\Carbon;
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
        // $countPeringatan = PeringatanProposal::where('is_open', false)->count();
        // $countFeedback = FeedbackProposal::where('is_open', false)->count();

        // $countPeringatanLpj = PeringatanLpj::where('is_open', false)->count();

        // $count = $countPeringatan + $countFeedback + $countPeringatanLpj;

        // view()->share('isOpenCount', $count);
        // view()->share('countPeringatan', $countPeringatan);
        // view()->share('countPeringatanLpj', $countPeringatanLpj);
        // view()->share('countFeedback', $countFeedback);

        config(['app.locale' => 'id']);
	    Carbon::setLocale('id');

        view()->composer('*', function ($view) 
        {
            if(!auth()->user()) return;

            $countPeringatan =Peringatan::where('is_open', false)->where('user_id', auth()->user()->id)->count();
            $countFeedback = Feedback::where('is_open', false)->where('user_id', auth()->user()->id)->count();
            $countKomentar = Komentar::where('is_open', false)->where('user_id', auth()->user()->id)->count();

            $count = $countPeringatan + $countFeedback + $countKomentar;

            $view->with('isOpenCount', $count);
        });  
    }
}
