<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use DB;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if (config('app.env') != 'local') {
            $this->app['request']->server->set('HTTPS', true);
        }
        Schema::defaultStringLength(191);
        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                $searchTerm = strtolower($searchTerm);
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        str_contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);

                            $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                                if (str_contains($relationAttribute, '->')) {
                                    $searchCheck = explode('->', $relationAttribute);
                                    if (count($searchCheck) >= 2) {
                                        $attribute = "JSON_EXTRACT(`$searchCheck[0]`" . ",'$.$searchCheck[1]')";
                                        // $relationAttribute = $searchCheck[0].'->'."'$.$searchCheck[1]'";
                                    } else {
                                        $relationAttribute = $searchCheck[0];
                                    }
                                }
                                $words = explode(' ', $searchTerm);
                                foreach ($words as $key => $word) {
                                    # code...
                                    $query->where(DB::raw("lower($relationAttribute)"), 'LIKE', "%{$word}%");
                                }
                            });
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            if (str_contains($attribute, '->')) {
                                $searchCheck = explode('->', $attribute);
                                if (count($searchCheck) >= 2) {
                                    $attribute = "JSON_EXTRACT(`$searchCheck[0]`" . ",'$.$searchCheck[1]')";
                                    // $attribute = $searchCheck[0].'->'."'$.$searchCheck[1]'";
                                } else {
                                    $attribute = $searchCheck[0];
                                }
                            }
                            $words = explode(' ', $searchTerm);
                            foreach ($words as $key => $word) {
                                # code...
                                $query->orWhere(DB::raw("lower($attribute)"), 'LIKE', "%{$word}%");
                            }

                            // dd($attribute);
                        }
                    );
                }
            });

            return $this;
        });
    }
}
