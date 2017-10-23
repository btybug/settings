<div class="besetting m-10 p-15 bg-white overflow-y-hidden">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Notification type
            </div>
            <div class="panel-body">
                <button class="btn btn-success alert-success" onClick="openNotyType('success')" type="button">Success
                </button>
                <button class="btn btn-info alert-info" onClick="openNotyType('info')" type="button">Info</button>
                <button class="btn btn-warning alert-warning" onClick="openNotyType('warning')" type="button">Warning
                </button>
                <button class="btn btn-danger alert-danger" onClick="openNotyType('danger')" type="button">Danger
                </button>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Notification Positioning
            </div>
            <div class="panel-body hide">
                <form action="" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    <ul class="buttons">
                        <li>
                            <a href="#" class="btn btn-success btn-md disabled" role="button">Success</a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-danger btn-md disabled" role="button">Error</a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-warning btn-md disabled" role="button">Warning</a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-info btn-md disabled" role="button">Info</a>
                        </li>
                    </ul>
                    <ul class="positions">
                        <li>
                            <select class="form-control">
                                <option>Top</option>
                                <option>Top Left</option>
                                <option>Top Right</option>
                                <option>Bottom</option>
                                <option>Bottom Left</option>
                                <option>Bottom Right</option>
                                <option>Center</option>
                                <option>Center Left</option>
                                <option>Center Right</option>
                            </select>
                        </li>
                        <li>
                            <select class="form-control">
                                <option>Top</option>
                                <option>Bottom</option>
                                <option>Top Left</option>
                                <option>Top Right</option>
                                <option>Bottom Left</option>
                                <option>Bottom Right</option>
                                <option>Center</option>
                                <option>Center Left</option>
                                <option>Center Right</option>
                            </select>
                        </li>
                        <li>
                            <select class="form-control">
                                <option>Top</option>
                                <option>Bottom</option>
                                <option>Top Left</option>
                                <option>Top Right</option>
                                <option>Bottom Left</option>
                                <option>Bottom Right</option>
                                <option>Center</option>
                                <option>Center Left</option>
                                <option>Center Right</option>
                            </select>
                        </li>
                        <li>
                            <select class="form-control">
                                <option>Top</option>
                                <option>Bottom</option>
                                <option>Top Left</option>
                                <option>Top Right</option>
                                <option>Bottom Left</option>
                                <option>Bottom Right</option>
                                <option>Center</option>
                                <option>Center Left</option>
                                <option>Center Right</option>
                            </select>
                        </li>
                    </ul>
                    <ul class="submit-btns">
                        <li>
                            <button type="submit" class="btn btn-primary btn-md" name="save">Save</button>
                        </li>
                        <li>
                            <button type="submit" class="btn btn-primary btn-md" name="save">Save</button>
                        </li>
                        <li>
                            <button type="submit" class="btn btn-primary btn-md" name="save">Save</button>
                        </li>
                        <li>
                            <button type="submit" class="btn btn-primary btn-md" name="save">Save</button>
                        </li>
                    </ul>
                </form>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-4"><a href="javascript:;" onClick="openNoty('left', 'top')"
                                             class="btn btn-block p-t-30 p-b-30 m-b-10  bg-silver-darker"></a></div>
                    <div class="col-xs-4"><a href="javascript:;" onClick="openNoty('center', 'top')"
                                             class="btn btn-block p-t-30 p-b-30 m-b-10 bg-silver-darker"></a></div>
                    <div class="col-xs-4"><a href="javascript:;" onClick="openNoty('right', 'top')"
                                             class="btn btn-block p-t-30 p-b-30 m-b-10 bg-silver-darker"></a></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><a href="javascript:;" onClick="openNoty('left', 'center')"
                                             class="btn btn-block p-t-30 p-b-30 m-b-10 bg-silver-darker"></a></div>
                    <div class="col-xs-4"><a class="btn btn-block p-t-30 p-b-30 m-b-10 bg-green"></a></div>
                    <div class="col-xs-4"><a href="javascript:;" onClick="openNoty('right', 'center')"
                                             class="btn btn-block p-t-30 p-b-30 m-b-10 bg-silver-darker"></a></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><a href="javascript:;" onClick="openNoty('left', 'bottom')"
                                             class="btn btn-block p-t-30 p-b-30 m-b-10 bg-silver-darker"></a></div>
                    <div class="col-xs-4"><a href="javascript:;" onClick="openNoty('center', 'bottom')"
                                             class="btn btn-block p-t-30 p-b-30 m-b-10 bg-silver-darker"></a></div>
                    <div class="col-xs-4"><a href="javascript:;" onClick="openNoty('right', 'bottom')"
                                             class="btn btn-block p-t-30 p-b-30 m-b-10 bg-silver-darker"></a></div>
                </div>
            </div>
        </div>
    </div>
</div>


@section('CSS')
    {!! HTML::style('/public/libs/animate/css/animate.css') !!}
@stop
@section('JS')

    {!! HTML::script('public/libs/bootstrap-notify/js/bootstrap-notify.min.js') !!}
    <script>

        var ntype = 'info';
        var pla = 'left';
        var plf = 'top';

        $.notifyDefaults({
            type: 'info',
            allow_dismiss: true,
            animate: {
                enter: 'animated fadeInUp',
                exit: "animated fadeOutDown"
            }
        });

        function openNotyType(nt) {
            ntype = nt;
            $.notify('You can not close me!', {'type': ntype, 'placement': {'align': pla, 'from': plf},});
        }

        function openNoty(pa, pf) {
            pla = pa;
            plf = pf;
            $.notify('You can not close me!', {'type': ntype, 'placement': {'align': pla, 'from': plf},});
        }
    </script>

@stop
