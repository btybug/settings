<style>
    #preview-json, #query-results {
        border: 1px solid #dfdfdf;
        min-height: 40px;
        font-family: "Courier New", Courier, monospace;
        padding: 10px;
        word-wrap: break-word;
    }

    .radio-container label, .n-records {
        display: table;
    }

    .n-records {
        margin-top: 10px;
        margin-left: 20px;
    }

    .sub-radio {
        margin-left: 20px;
    }
</style>

<div class="row m-b-10 filter-properties">
    <div class="col-md-4">
        {!! Form::text('title',@$info['title'],['class' => 'form-control', 'id' => 'name' ,'placeholder' => 'Filter Name']) !!}
    </div>
    <div class="col-md-5">
        <label class="pull-left m-r-20" style="line-height: 30px;">Create & Return results as</label>
        <select name="return_result" class="form-control" style="width: 50%">
            <option value="user_list">User list</option>
            <option value="data_array">Data array</option>
            <option value="filter_field">Filter Field</option>
        </select>
    </div>
    <div class="col-md-3">
        {!! Form::submit('Save', array('class' => 'btn btn-primary pull-right')) !!}
        {!! Form::button('Run Query', array('class' => 'btn btn-warning pull-right m-r-10', 'id' => 'run-query')) !!}
    </div>
</div>

<input type="hidden" name="id" value="{{@$id}}"/>
<input type="hidden" name="filter_json" value=""/>

<div class="row">
    <div class="clearfix col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading  bg-black-darker text-white">Filter Builder</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="">Module</label>
                    @if(!isset($filter))
                        {!! Form::select('module_id', $modules, @$info['title'], ['class' => 'form-control','id'=>'modules']) !!}
                    @else
                        <div class="p-t-5 p-l-5">{!! $filter->module->title !!}</div>
                    @endif
                </div>
                <div class="form-group hide" id="filters_div">
                    <label for="">Filterable Columns</label>
                    <select class="form-control" id="filters"></select>
                </div>
                <div class="search-container hide">
                    <div class="form-group">
                        <label>Choose Operation</label>
                        <select name="operation" class="form-control"></select>
                    </div>
                    <!-- Field Types -->

                    <!-- Text Field -->
                    <div class="field-type hide" data-type="text">
                        <div class="form-group">
                            <label for="">Search value</label>
                            <input type="text" name="value_text" placeholder="Search Value" class="form-control"/>
                        </div>
                    </div>

                    <!-- Number Field -->
                    <div class="field-type hide" data-type="number">
                        <div class="form-group">
                            <label for=""><b>Search value</b></label>
                            <div class="form-group single-container hide">
                                <input type="number" name="value_number" placeholder="Search Value"
                                       class="form-control"/>
                            </div>
                            <div class="form-group range-container hide">
                                <label>From</label>
                                <input type="number" name="value_number_from" placeholder="From" class="form-control"/>
                                <label>To</label>
                                <input type="number" name="value_number_to" placeholder="To" class="form-control"/>
                            </div>
                        </div>
                    </div>

                    <!-- Date Field -->
                    <div class="field-type hide" data-type="date">
                        <label for=""><b>Date</b></label>
                        <div class="form-group single-container hide">
                            <input type="date" name="value_date" class="form-control"/>
                        </div>
                        <div class="form-group range-container hide">
                            <label>From</label>
                            <input type="date" name="value_date_from" class="form-control"/>
                            <label>To</label>
                            <input type="date" name="value_date_to" class="form-control"/>
                        </div>
                    </div>

                    <!--/ Field Types -->

                    <div class="form-group data-array result-type hide">
                        <label><b>Data Array</b></label>
                        <select name="data_array" class="form-control" multiple>
                            <option value="">Random</option>
                            <option value="">Newest</option>
                            <option value="">Oldest</option>
                            <option value="">A to Z</option>
                            <option value="">Z to A</option>
                        </select>
                    </div>

                    <div class="form-group filter-field result-type hide">
                        <label><b>Filter Field</b></label>
                        <select name="filter_field" class="form-control">
                            <option value="">Random</option>
                            <option value="">Newest</option>
                            <option value="">Oldest</option>
                            <option value="">A to Z</option>
                            <option value="">Z to A</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <div id="display-number" class="sub-options radio-container">
                            <label><b>Display Number</b></label>
                            <label>
                                <input type="radio" name="display" value="all"/>
                                All Results
                            </label>
                            <label>
                                <input type="radio" name="display" value="value"/>
                                Value
                            </label>
                            <div class="sub-radio hide value-options">
                                <input type="text" name="first_n" value="0"/>
                                <div class="sorting-options">
                                    <label>Sorting</label>
                                    <select name="sorting" class="form-control">
                                        <option value="">Random</option>
                                        <option value="">Newest</option>
                                        <option value="">Oldest</option>
                                        <option value="">A to Z</option>
                                        <option value="">Z to A</option>
                                        <option value="">Advanced Sorting</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading  bg-black-darker text-white">Results</div>
            <div class="panel-body">
                <div id="query-results"></div>
            </div>
        </div>
    </div>
</div>

<pre id="preview-json"></pre>

@push('javascript')
    <script>
        $('document').ready(function () {
            var columnObject = {};
            var filterObject = {};

            var filterJSON = {};
            @if(isset($json) and $json != '')
                filterJSON = JSON.parse('{!!str_replace("\\\\","\\",$json)!!}');
            @endif

            $('#modules').change(function () {
                var module = $(this).val();
                var filter = $('#filters');

                postAjax('/admin/settings/filter/filters', {module: module}, function (data) {
                    $('#filters_div').removeClass('hide');
                    filter.html(data);

                    if (filterJSON.config) {
                        filter.val(filterJSON.config.column).trigger('change');
                    }
                });
            });

            $('#filters').change(function () {
                var filter = $(this).val();
                postAjax('/admin/settings/filter/filterdata', {
                    module: $('#modules').val(),
                    filter: filter
                }, function (data) {
                    var filter = columnObject = JSON.parse(data);
                    var fieldType = filter.field_type;

                    var operation = $('[name=operation]');

                    var operations = ['=', '!='];
                    if (fieldType == 'number' || fieldType == 'date') {
                        operations.push('>');
                        operations.push('<');
                        operations.push('>=');
                        operations.push('<=');
                        operations.push('range');
                    }

                    if (fieldType == 'text') {
                        operations.push('Like');
                        operations.push('Not Like');
                    }

                    operation.html('');
                    operation.addOption('', 'Choose Operation');
                    $.each(operations, function (i, v) {
                        operation.addOption(v, v);
                    });

                    BBShow('.search-container');
                    BBHide('.field-type');
                    BBShow('[data-type=' + fieldType + ']');

                    if (filterJSON.config) {
                        $('[name=operation]').val(filterJSON.conditions.where[columnObject.main_type][$('#filters option:selected').text()].condition);
                        if (columnObject.field_type != 'date') {
                            $('[name=value_' + columnObject.field_type + ']').val(filterJSON.conditions.where[columnObject.main_type][$('#filters option:selected').text()].value);
                        }
                    }

                    generateJOSN();
                });
            });

            $('body').on('change', '[name=operation]', function () {
                var fieldType = columnObject.field_type;
                var value = $(this).val();
                if (fieldType == 'date' || fieldType == 'number') {
                    BBHide('.range-container');
                    BBHide('.single-container');

                    if (value == 'range') {
                        BBShow('.range-container');
                    } else {
                        BBShow('.single-container');
                    }
                }
            });

            $('[name=display]').change(function () {
                var $this = $(this);
                var value = $this.val();

                $('#display-number').find('.sub-radio').addClass('hide');

                $('.' + value + '-options').removeClass('hide');

                generateJOSN();
            });

            $('.radio-conditional').change(function () {
                var conditional = $(this).closest('.radio-container').find('.conditional');
                $(this).closest('.field-type').find('.conditional').addClass('hide');
                conditional.removeClass('hide');
            });

            $('[name=return_result]').change(function () {
                var value = $(this).val();

                console.log(value);

                BBHide('.result-type');

                if (value == 'filter_field') {
                    BBShow('.filter-field');
                }

                if (value == 'data_array') {
                    BBShow('.data-array');
                }
            });

            function BBShow(selector) {
                $(selector).removeClass('hide');
            }

            function BBHide(selector) {
                $(selector).addClass('hide');
            }

            jQuery.fn.addOption = function (key, value) {
                $(this).append($('<option>', {value: key}).text(value));
            };

            $('.search-container, .filter-properties').find('input, select, textarea').each(function () {
                console.log('Generator Called!');
                var $this = $(this);
                $this.change(function () {
                    generateJOSN();
                });
            });

            generateJOSN();

            function generateJOSN() {

                var filter = $('#filters');
                var display = $('[name=display]:checked');

                if (columnObject.field_type) {

                    filterObject.filter_name = $('[name=title]').val();
                    filterObject.model = columnObject.model;
                    filterObject.field_id = filter.val();

                    filterObject.conditions = {};
                    filterObject.conditions.where = {};
                    filterObject.conditions.where[columnObject.main_type] = {};
                    filterObject.conditions.where[columnObject.main_type][$('#filters option:selected').text()] = {};
                    filterObject.conditions.where[columnObject.main_type][$('#filters option:selected').text()].condition = $('[name=operation]').val();


                    console.log(display.val());

                    if (display.val() != 'all' && display.val() != undefined) {
                        filterObject.conditions.limit = 10;
                        filterObject.conditions.order = {
                            id: "DESC"
                        };
                    }

                    if (columnObject.field_type == 'date' || columnObject.field_type == 'number') {

                        filterObject.conditions.where[columnObject.main_type][$('#filters option:selected').text()].from = $('[name=value_' + columnObject.field_type + '_from]').val();

                        filterObject.conditions.where[columnObject.main_type][$('#filters option:selected').text()].to = $('[name=value_' + columnObject.field_type + '_to]').val();

                    } else {
                        filterObject.conditions.where[columnObject.main_type][$('#filters option:selected').text()].value = $('[name=value_' + columnObject.field_type + ']').val();
                    }


                    // Extras
                    filterObject.config = {};
                    filterObject.config.module = $('[name=module_id]').val();
                    filterObject.config.column = filter.val();

                    $('#preview-json').html(JSON.stringify(filterObject, null, 4));

                    $('[name=filter_json]').val(JSON.stringify(filterObject));
                }

            }

            $('#run-query').click(function () {
                postAjax('/admin/settings/filter/run-query', {json: JSON.stringify(filterObject)}, function (data) {
                    var results = $('#query-results');
                    console.log($.type(data));
                    if ($.type(data) == 'array') {
                        results.html('');
                        results.append($('<ul class="result-list"></ul>'));
                        $.each(data, function (k, v) {
                            results.find('.result-list').append('<li>' + v.username + '</li>');
                        });
                    }
                });
            });

            if (filterJSON.filter_name) {
                $('#modules').val(filterJSON.config.module).trigger('change');

            }

            console.log(filterJSON);

        });
    </script>

@endpush 