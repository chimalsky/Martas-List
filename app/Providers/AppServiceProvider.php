<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Builder::macro('addSubSelect', function ($column, $query) {
            if (is_null($this->columns)) {
                $this->select($this->from.'.*');
            }

            return $this->selectSub($query->limit(1), $column);
        });

        Blade::directive('route', function ($expression) {
            return "<?php echo route({$expression}) ?>";
        });
        Blade::directive('routeIs', function ($expression) {
            return "<?php if (request()->routeIs({$expression})) : ?>";
        });
        Blade::directive('endrouteIs', function () {
            return '<?php endif; ?>';
        });

        Blade::directive('routeIsnt', function ($expression) {
            return "<?php if (!request()->routeIs({$expression})) : ?>";
        });
        Blade::directive('endrouteIsnt', function () {
            return '<?php endif; ?>';
        });

        //BladeX::component('mailcoach::app.components.form.formButton', 'form-button');

        //Blade::component('components.attribute.field', 'resource.attribute.field');
    }
}
