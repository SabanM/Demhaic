<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Auth;
use App\Models\Dform;
use Illuminate\Support\Facades\DB;

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
        /*if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }*/

        URL::forceRootUrl(config('app.url'));

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        if (session()->has('applocale')) {
            app()->setLocale(session('applocale'));
        }

        View::composer('layouts.app', function ($view) {

            $hasEntryToday = 0; // Default to null

            if (Auth::check()) {
                $today = now()->startOfDay(); // Get the start of the day (00:00:00)
                $userId = Auth::id();
            
                $entry = DB::table('entries')
                    ->where('created_at', '>=', $today)
                    ->orderBy('created_at','DESC')
                    ->where('user_id', $userId) // Ensure the entry belongs to the authenticated user
                    ->first();
            
              
            
                if ($entry) {
                
                    $check2 = Dform::find($entry->dform_id); // Use primary key lookup for efficiency
            
                    if ($check2 && $check2->type === 'Diary') {
                        $hasEntryToday = 1;
                    }
                }
            }
            
            $diaryForm = Auth::check() ? Auth::user()->dforms()->where('type', 'Diary')->first() : null;
            $weeklyForm = Auth::check() ? Auth::user()->dforms()->where('type', 'Weekly')->first() : null;
            $initialForm = Auth::check() ? Auth::user()->dforms()->where('type', 'Initial')->first() : null;

            if($diaryForm){
                $diaryFormQuestions = $diaryForm->questions()->get();
            }else{
                $diaryForm = Dform::where('type','Diary')->where('is_default', true)->first();

                if($diaryForm){
                $diaryFormQuestions = $diaryForm->questions()->get();

                    DB::table('dform_user')->insert([
                        'dform_id' => $diaryForm->id,
                        'user_id' => Auth::user()->id,
                    ]);
                }else{
                    $diaryFormQuestions = null;
                }
            }

            if($weeklyForm){
                $weeklyFormQuestions = $weeklyForm->questions()->get();
            }else{
                $weeklyForm = Dform::where('type','Diary')->where('is_default', true)->first();

                if($weeklyForm){
                $weeklyFormQuestions = $weeklyForm->questions()->get();

                    DB::table('dform_user')->insert([
                        'dform_id' => $weeklyForm->id,
                        'user_id' => Auth::user()->id,
                    ]);
                }else{
                    $weeklyFormQuestions = null;
                }
            }

            if($initialForm){
                $initialFormQuestions = $initialForm->questions()->get();
            }else{
                $initialForm = Dform::where('type','Initial')->where('is_default', true)->first();
                if($initialForm){
                    $initialFormQuestions = $initialForm->questions()->get();
                

                    DB::table('dform_user')->insert([
                        'dform_id' => $initialForm->id,
                        'user_id' => Auth::user()->id,
                    ]);
                }
                else{
                    $initialFormQuestions = null;
                }
            }
           


            $isCompleted = null;
            if (Auth::check() && $initialForm) {

                $isCompleted = DB::table('dform_user')
                    ->where('dform_id', $initialForm->id)
                    ->where('user_id', Auth::user()->id)
                    ->value('completed');
            }

            $view->with('initialForm', $initialForm);
            $view->with('diaryForm', $diaryForm);
            $view->with('weeklyForm', $weeklyForm);
            $view->with('isCompleted', $isCompleted);
            $view->with('hasEntryToday', $hasEntryToday);
            $view->with('initialFormQuestions', $initialFormQuestions);
            $view->with('diaryFormQuestions', $diaryFormQuestions);
            $view->with('weeklyFormQuestions', $weeklyFormQuestions);
        });

        URL::forceRootUrl(config('app.url'));
        URL::forceScheme('https');
    }
}
