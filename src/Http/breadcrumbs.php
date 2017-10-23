<?php

Breadcrumbs::register(
    'settings',
    function ($breadcrumbs) {
        $breadcrumbs->parent('admin');
        $breadcrumbs->push('Main Settings', url('admin/settings/system/main'));
    }
);


Breadcrumbs::register(
    'settings_tbl',
    function ($breadcrumbs) {
        $breadcrumbs->parent('admin');
        $breadcrumbs->push('Edit Settings');
    }
);

Breadcrumbs::register(
    'settings_emailtpls',
    function ($breadcrumbs) {
        $breadcrumbs->parent('admin');
        $breadcrumbs->push('Email Templates', url('admin/settings/email/core'));
    }
);

Breadcrumbs::register(
    'settings_emailtpl_edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('settings_emailtpls');
        $breadcrumbs->push('Edit Email');
    }
);

Breadcrumbs::register(
    'settings_uploaders',
    function ($breadcrumbs) {
        $breadcrumbs->parent('admin');
        $breadcrumbs->push('Uploaders', url('admin/settings/uploaders'));
    }
);

Breadcrumbs::register(
    'settings_uploaders_create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('settings_uploaders');
        $breadcrumbs->push('Add New Uploader');
    }
);

Breadcrumbs::register(
    'settings_uploaders_update',
    function ($breadcrumbs) {
        $breadcrumbs->parent('settings_uploaders');
        $breadcrumbs->push('Edit Uploader');
    }
);

Breadcrumbs::register(
    'settings_filters',
    function ($breadcrumbs) {
        $breadcrumbs->parent('admin');
        $breadcrumbs->push('Filters', url('admin/settings/filter'));
    }
);

Breadcrumbs::register(
    'settings_filters_create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('settings_filters');
        $breadcrumbs->push('Add New Filter');
    }
);

Breadcrumbs::register(
    'settings_filters_update',
    function ($breadcrumbs) {
        $breadcrumbs->parent('settings_filters');
        $breadcrumbs->push('Edit Filter');
    }
);

