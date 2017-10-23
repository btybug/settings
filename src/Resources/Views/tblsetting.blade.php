@extends('layouts.admin')
@section('content')
    {!! Breadcrumbs::render('settings_tbl') !!}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading bg-black text-white">
                    <h3 class="panel-title">Update Settings</h3>
                </div>
                {!! Form::open(['url'=>'/admin/settings/tablesettings']) !!}

                <div class="panel-body">
                    <table class="table table-bordered bg-white m-0">

                        @foreach($cols as $key=>$val)
                            <tr>
                                <td>{!! $val !!}</td>
                                <td>

                                    {!! Form::checkbox('cols[]', $key,in_array($key, $avail)?'checked' : '') !!} </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="col-md-12 text-center p-t-10">
                        <button id="singlebutton" name="singlebutton" class="btn btn-success">Save Changes</button>
                    </div>

                </div>
                {!! Form::hidden('bk', $bk) !!}
                {!! Form::hidden('code', $table_name) !!}

                {!! Form::close() !!}

            </div>
        </div>
    </div>
@stop 
