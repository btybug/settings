<?php

/*
  |--------------------------------------------------------------------------
  | Module Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for the module.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */


Route::group(
    ['prefix' => 'admin/settings', 'middleware' => ['admin:Users']],
    function () {
//        Route::controller('/filter', 'FilterController');
        Route::get('/filter', 'FilterController@getIndex');
        Route::get('/filter/create', 'FilterController@getCreate');
        Route::post('/filter/create', 'FilterController@postCreate');
        Route::get('/testmodal', 'FilterController@getTestModal');

//
        Route::get('/backlayout', 'BklayoutController@getIndex');
        Route::get('/backheader', 'BkheaderController@getIndex');
        Route::get('/backmenu', 'BkmenuController@getIndex');
        Route::get('/backmenu/create', 'BkmenuController@getCreate');
        Route::get('/backmenu/show/{id}', 'BkmenuController@getShow');
        Route::get('/backmenu/update/{id}', 'BkmenuController@getUpdate');
        Route::get('/backmenu/delete/{id}', 'BkmenuController@getDelete');
//        Route::controller('/email', 'EmailController');
        Route::get('/email/core/{id?}', 'EmailController@getCore');
        Route::get('/email/custom/{id?}', 'EmailController@getCustom');
        Route::get('/email/data/{id?}', 'EmailController@getData');
        Route::get('/email/settings', 'EmailController@getSettings');
        Route::get('/email/updateemail/{id}', 'EmailController@getUpdateemail');
        Route::post('/email/settings', 'EmailController@postSettings');
        Route::post('/email/deleteEmail', 'EmailController@deleteEmail');
        Route::post('/email/save', 'EmailController@save');
        Route::post('/email/addgroup', 'EmailController@postAddgroup');
        Route::post('/email/editgroup', 'EmailController@postEditgroup');
        Route::post('/email/deletegroup', 'EmailController@postDeletegroup');
//        Route::controller('/system', 'SystemController');
        Route::get('/system', 'SystemController@getIndex');
        Route::get('/system/login-registration', 'SystemController@getLoginRegistration');
        Route::get('/system/notifications', 'SystemController@getNotifications');
        Route::get('/system/url-menger', 'SystemController@getUrlMenger');
        Route::get('/system/adminemails', 'SystemController@getAdminemails');


        Route::get('/lang', 'LangController@getIndex');
//        Route::controller('/uploaders', 'UploaderController');
        Route::get('/uploaders', 'UploaderController@getIndex');
        Route::post('/uploaders/data', 'UploaderController@getData');
        Route::get('/uploaders/create', 'UploaderController@getCreate');
//        Route::controller('/coreassets', 'CoreassetsController');


        Route::post('/save-social', array('as' => 'sotial.keys', 'uses' => 'SystemController@saveSocialApiKeys'));
        Route::post('/system-store', array('as' => 'system.store', 'uses' => 'SystemController@storeSystem'));
        Route::post('/url-manager', array('as' => 'url.manager', 'uses' => 'SystemController@urlManager'));
        Route::post('/general', array('as' => 'general.store', 'uses' => 'GeneralController@store'));
        Route::post(
            '/social-login-store',
            array('as' => 'general.socialLoginStore', 'uses' => 'GeneralController@socialLoginStore')
        );
        Route::post('/save-email', array('as' => 'system.email.save', 'uses' => 'EmailController@save'));
        Route::post('/delete-email', array('as' => 'system.email.delete', 'uses' => 'EmailController@deleteEmail'));
        Route::post('/add-email', array('as' => 'system.email.new', 'uses' => 'EmailController@addEmail'));
        Route::post('/edit-email', array('as' => 'system.email.edit', 'uses' => 'EmailController@editEmail'));
        Route::post('/duplicate-email', array('as' => 'system.email.duplicate', 'uses' => 'EmailController@duplicateEmail'));
        Route::get('/test', 'EmailController@test');


//        Route::controller('/api-settings', 'ApiSettingsController');
//        Route::controller('/', 'SettingController');
        Route::get('/backnotify', 'SettingController@getBacknotify');
        Route::get('/api-settings', 'ApiSettingsController@getIndex');
        Route::post('/api-settings/update', 'ApiSettingsController@postUpdate');


        Route::get('/backgeneral', 'BackendThemeController@getIndex');

        Route::get('/theme-settings/{slug}/{role}', 'BackendThemeController@getSettings');
        Route::post('/settings/{slug}', 'BackendThemeController@postSettings');
        Route::post('/theme-settings/{slug}/{role}', 'BackendThemeController@postSettingsLive');
        Route::post('/theme-settings/{slug}', 'BackendThemeController@postThemeSettings');
        Route::post('/theme-edit/live-save', 'BackendThemeController@postLiveSave');
        Route::post('/theme-edit/checkboxes', 'BackendThemeController@postEditCheckboxes');
        Route::post('/upload-theme', 'BackendThemeController@postUploadTheme');
        Route::post('/delete-theme', 'BackendThemeController@postDeleteTheme');
//Admin lyouts
        Route::get('/pages-layout', 'PagesLayoutController@getPagesLayout');
        Route::get('/pages-layout/delete/{slug}', 'PagesLayoutController@getPagesLayoutDelete');
        Route::get('/pages-layout/settings/{slug}', 'PagesLayoutController@settings');
        Route::post('/pages-layout/settings/{slug}/{save?}', 'PagesLayoutController@postLayoutSettings');
        Route::post('/admin-templates/settings/{slug}/{save?}', 'PagesLayoutController@postLayoutSettings');

        Route::get('/admin-templates', 'AdminTemplatesController@getPagesLayout');
        Route::get('/main-body', 'AdminTemplatesController@getMainBody');
        Route::any('/units', 'AdminTemplatesController@getUnits');
//        Route::get('/pages-layout/delete/{slug}', 'PagesLayoutController@getPagesLayoutDelete');
//        Route::get('/admin-templates/settings/{slug}', 'AdminTemplatesController@settings');
//        Route::post('/pages-layout/settings/{slug}/{save?}', 'PagesLayoutController@postLayoutSettings');

        Route::post('/upload-layout', 'PagesLayoutController@postUploadLayout');

        //front pages layouts
        Route::get('/frontend/general', 'SystemController@getMain');
        Route::post('/frontend/general', 'SystemController@postMain');
        // page layouts
        Route::get('/frontend/layout', 'LayoutController@getIndex');
//            Route::get('/frontend/create-layout/{key?}', \App\Models\Themes\Themes::active()->namespace_to_create);
        Route::get('/frontend/layout-delete/{key}', 'LayoutController@getDeleteLayout');

        Route::get('/frontend', 'FrontPagesLayoutController@getPageLayout');
        Route::get('/frontend/page-layout-builder', 'FrontPagesLayoutController@getPageLayoutBuilder');
        Route::post('/frontend/deletebulk', 'FrontPagesLayoutController@postDeletebulk');
        Route::post('/frontend/delete-layout', 'FrontPagesLayoutController@postDeleteLayout');
        Route::post('/frontend/page-layout-builder', 'FrontPagesLayoutController@postPageLayoutBuilder');
        Route::any('/frontend/data-layouts', 'FrontPagesLayoutController@getDataLayouts');
        Route::get('/frontend/edit-page-layout/{id}', 'FrontPagesLayoutController@getEditPageLayout');
        Route::post('/frontend/edit-page-layout/{id}', 'FrontPagesLayoutController@postEditPageLayout');
        Route::get('/frontend/edit-layout-desktop/{id}', 'FrontPagesLayoutController@getEditPageLayoutDesktop');
        Route::get('/frontend/edit-layout-landscape/{id}', 'FrontPagesLayoutController@getEditPageLayoutLandscape');
        Route::get('/frontend/edit-layout-portrait/{id}', 'FrontPagesLayoutController@getEditPageLayoutPortrait');
        Route::get('/frontend/edit-layout-mobile/{id}', 'FrontPagesLayoutController@getEditPageLayoutMobile');
    }
);

Route::group(['prefix' => 'admin/templates', 'middleware' => ['admin:Users']], function () {
//
//        Route::get('/', 'TemplateController@getIndex');
//        Route::get('/front-themes', 'TemplateController@gatFrontThemes');
//        Route::get('/front-themes-activate/{slug}', 'TemplateController@activateFrontTheme');
//        Route::get('/tpl-variations/{slug}', 'TemplateController@getTplVariations');
//        Route::post('/tpl-variations/{slug}', 'TemplateController@postTplVariations');
//        Route::post('/get-variations', 'TemplateController@postGetVariations');
//        Route::post('/edit-variation', 'TemplateController@postEditVariation');
//        Route::get('/delete-variation/{slug}', 'TemplateController@getDeleteVariation');
    Route::get('/settings-live/{slug}', 'TemplateController@TemplatePerview');
    Route::get('/settings-live-layout/{slug}', 'TemplateController@TemplateLayoutPerview');
//        Route::get('/settings-iframe-layout/{slug}', 'TemplateController@TemplateIframeLayout');
//        Route::post('/front-layout-settings/{slug}', 'TemplateController@frontLayoutSettings');
//        Route::get('/settings-iframe/{slug}/{page_id}/{edit?}', 'TemplateController@TemplatePerviewIframe');
//        Route::get('/settings-edit-theme/{slug}/{settings?}', 'TemplateController@TemplatePerviewEditIframe');
//        Route::post('/settings/{id}/{save?}', 'TemplateController@postSettings');
//
//
//    Route::post('/new-type', 'TemplateController@postNewType');
//        Route::post('/delete-type', 'TemplateController@postDeleteType');
//        Route::post('/delete', 'TemplateController@postDelete');
//        Route::post('/upload-template', 'TemplateController@postUploadTemplate');
//        Route::post('/templates-with-type', 'TemplateController@postTemplatesWithType');
//        Route::post('/templates-in-modal', 'TemplateController@postTemplatesInModal');
});

Route::group(
    ['prefix' => 'api/settings'],
    function () {
        Route::get('/mailgroups', 'Api\MailGroupsController@getIndex');
        Route::get('/mailgroups/group', 'Api\MailGroupsController@getGroup');
    }
);

Route::group(
    ['prefix' => 'api/social-network'],
    function () {
        Route::get('login/{social}/{evemt?}', 'Api\SotialAuthorisationController@redirectToProvider');
        Route::get('auth/{social}/callback', 'Api\SotialAuthorisationController@handleProviderCallback');
    }
);
