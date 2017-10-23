@extends('layouts.admin')
@section('content')

    <ol class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li class="active">Back End Settings</li>
    </ol>
    <div class="row">
        <div class="col-md-12">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"><a href="/admin/settings/backgeneral" role="tab">General</a></li>
                <li role="presentation"><a href="/admin/settings/backnotify" aria-controls="notifications" role="tab">Notifications
                        & Tool Tips</a></li>
                <li role="presentation" class="active"><a href="/admin/settings/backlayout" aria-controls="layout"
                                                          role="tab">Layout</a></li>
                <li role="presentation"><a href="/admin/settings/backheader" aria-controls="header"
                                           role="tab">Header</a></li>
                <li role="presentation"><a href="/admin/settings/backmenu" aria-controls="adminMenu" role="tab">Admin
                        Menus</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content p-10 bg-silver overflow-y-hidden">

                <div role="tabpanel" class="tab-pane active" id="layout">
                    layout will resides here
                    <div class="clearfix"></div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-success btn-block" id="settings_savebtn">&nbsp;&nbsp;Save&nbsp;&nbsp;</button>
                    </div>
                </div>


            </div>
        </div>
    </div>

@stop
