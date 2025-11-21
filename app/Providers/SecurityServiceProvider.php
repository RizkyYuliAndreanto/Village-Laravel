<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SecurityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('security', function () {
            return new \App\Services\SecurityService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load security configuration
        $this->mergeConfigFrom(__DIR__ . '/../../config/security.php', 'security');

        // Register Blade directives untuk keamanan
        $this->registerBladeDirectives();

        // Set secure session configuration
        $this->configureSecureSessions();

        // Disable potentially dangerous PHP functions
        $this->disableDangerousFunctions();
    }

    /**
     * Register Blade directives untuk keamanan
     */
    protected function registerBladeDirectives(): void
    {
        // Directive untuk sanitize output
        Blade::directive('sanitize', function ($expression) {
            return "<?php echo htmlspecialchars($expression, ENT_QUOTES, 'UTF-8'); ?>";
        });

        // Directive untuk escape JavaScript
        Blade::directive('js_escape', function ($expression) {
            return "<?php echo json_encode($expression, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>";
        });

        // Directive untuk CSRF protection
        Blade::directive('csrf_meta', function () {
            return '<meta name="csrf-token" content="<?php echo csrf_token(); ?>">';
        });
    }

    /**
     * Configure secure sessions
     */
    protected function configureSecureSessions(): void
    {
        if ($this->app->environment('production')) {
            ini_set('session.cookie_secure', '1');
            ini_set('session.cookie_httponly', '1');
            ini_set('session.cookie_samesite', 'Strict');
            ini_set('session.use_strict_mode', '1');
        }
    }

    /**
     * Disable dangerous PHP functions jika memungkinkan
     */
    protected function disableDangerousFunctions(): void
    {
        $dangerousFunctions = [
            'exec',
            'shell_exec',
            'system',
            'passthru',
            'eval',
            'file_get_contents',
            'file_put_contents',
            'fopen',
            'fwrite',
            'fputs'
        ];

        // Note: Tidak bisa disable functions di runtime,
        // tapi bisa log jika ada yang mencoba menggunakan
        foreach ($dangerousFunctions as $function) {
            if (function_exists($function)) {
                // Log warning tentang dangerous functions yang masih enabled
                \Log::debug("Dangerous function '{$function}' is still enabled");
            }
        }
    }
}
