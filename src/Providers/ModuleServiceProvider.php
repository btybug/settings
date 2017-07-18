<?php

namespace Sahakavatar\Settings\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    private $roleTheme = array();
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'settings');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'settings');
        $tubs = [
            'settings' => [
                [
                    'title' => 'Login & Registration',
                    'url' => '/admin/settings/system/login-registration',
                ],
                [
                    'title' => 'System',
                    'url' => '/admin/settings/system',
                ],
                [
                    'title' => 'Notifications',
                    'url' => '/admin/settings/system/notifications',
                ],
                [
                    'title' => 'URL menger',
                    'url' => '/admin/settings/system/url-menger',
                ],
                [
                    'title' => 'Admin Emails',
                    'url' => '/admin/settings/system/adminemails',
                ],
                [
                    'title' => 'Api settings',
                    'url' => '/admin/settings/api-settings',
                ],
                [
                    'title' => 'Language',
                    'url' => '/admin/settings/lang',
                ]
            ],
            'backend_settings'=>[
                [
                    'title' => 'Admin theme',
                    'url' => '/admin/settings/backgeneral',
                    'icon' => 'fa fa-cub'
                ],[
                    'title' => 'Admin Layouts',
                    'url' => '/admin/settings/pages-layout',
                    'icon' => 'fa fa-cub'
                ],[
                    'title' => 'Page Layout',
                    'url' => '/admin/settings/admin-templates',
                    'icon' => 'fa fa-cub'
                ],[
                    'title' => 'Main body',
                    'url' => '/admin/settings/main-body',
                    'icon' => 'fa fa-cub'
                ],[
                    'title' => 'Units',
                    'url' => '/admin/settings/units',
                    'icon' => 'fa fa-cub'
                ],
            ],'frontend'=>[
                [
                    'title' => 'Main',
                    'url' => '/admin/settings/frontend/general',
                    'icon' => 'fa fa-cub'
                ],[
                    'title' => 'Page Layouts',
                    'url' => '/admin/settings/frontend/layout',
                    'icon' => 'fa fa-cub'
                ]
            ]
        ];

        \Eventy::action('my.tab', $tubs);
//        \Eventy::action('user_send_email', 'edo.terakyan@gmail.com');

    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
