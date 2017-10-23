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

<div class="row toolbarNav p-b-0">
    <div class="row">
        <div class="col-md-6" id="filter-fields">
            <div class="panel panel-default">
                <div class="panel-heading  bg-black-darker text-white">{{$module['title']}} Module</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label><b>Filter Name:</b> <span id="filter-name">Filter_{{$module['title']}}_{{$criteria['title']}}</span></label>
                    </div>
                    <div class="form-group">
                        <label><b>Criteria:</b> {{$criteria['title']}}</label>
                    </div>
                    <div class="form-group">
                        <label>Choose Operation</label>
                        <select name="operation" class="form-control">
                            <option value=""></option>
                            <option value="=">=</option>
                            <option value="!=">!=</option>
                            <option value=">=">>=</option>
                            <option value="<="><=</option>
                            <option value="like">Like</option>
                            <option value="not_like">Not Like</option>
                        </select>
                    </div>
                    <div class="form-group hide">
                        <label>Value</label>
                        <input type="text" class="form-control" name="filter-value"/>
                    </div>
                    <div class="form-group">
                        <div id="display-number" class="sub-options radio-container">
                            <label><b>Display Number</b></label>
                            <label>
                                <input type="radio" name="display" value="single"/>
                                Single
                            </label>
                            <div class="sub-radio hide single-options">
                                <label>
                                    <input type="radio" name="single" value="first"/>
                                    First Record
                                </label>
                                <label>
                                    <input type="radio" name="single" value="last"/>
                                    Last Record
                                </label>
                                <label>
                                    <input type="radio" name="single" value="user_input"/>
                                    User Input
                                </label>
                            </div>
                            <label>
                                <input type="radio" name="display" value="multiple"/>
                                Multiple
                            </label>
                            <div class="sub-radio hide multiple-options">
                                <label>
                                    <input type="radio" name="multiple" value="first"/>
                                    First (N) Record
                                    <input type="number" class="hide n-records" name="first_n" value="0" min="0"/>
                                </label>
                                <label>
                                    <input type="radio" name="multiple" value="last"/>
                                    Last (N) Record
                                    <input type="number" class="hide n-records" name="last_n" value="0" min="0"/>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::submit(' Save ', array('class' => 'btn btn-primary')) !!}
                    </div>
                    <div id="preview-json">JSON Preview</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading  bg-black-darker text-white">Query Results</div>
                <div class="panel-body">
                    <div id="query-results">Query Results</div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $('#filter-fields').find('input, select').each(function () {
        var $this = $(this);
        if ($this.is('select')) {
            $this.change(function () {
                generateJOSN();
            });
        }

        if ($this.is('input')) {
            $this.on('keydown', function () {
                generateJOSN();
            });
        }
    });

    $('[name=multiple]').change(function () {
        var $this = $(this);
        $('.n-records').addClass('hide');
        $this.closest('label').find('input[type=number]').first().removeClass('hide');
    });

    $('[name=display]').change(function () {
        var $this = $(this);
        var value = $this.val();

        $('#display-number').find('.sub-radio').addClass('hide');

        $('.' + value + '-options').removeClass('hide');
    });

    $('[name=operation]').change(function () {
        var $val = $(this).val();
        var filterValue = $('[name=filter-value]').parent('.form-group');
        filterValue.addClass('hide');
        if ($val) {
            filterValue.removeClass('hide');
        }
    });

    generateJOSN();

    function generateJOSN() {
        var json = {};

        json.filter_name = $('#filter-name').text();
        json.model = "{{addslashes($module['model'])}}";
        json.where = {};
        json.operation = $('[name=operation]').val();

        json.criteria = $('[name=criteria]').val();
        if (json.criteria != '') {
            json.filter = $('[name=' + json.criteria + ']').val();
        }

        $('#preview-json').text(JSON.stringify(json));
    }

    function hideSuboptions() {
        $('.sub-options').addClass('hide');
    }

    function showSubOption(selector) {
        hideSuboptions();
        $(selector).removeClass('hide');
    }

    $('[name=criteria]').change(function () {
        var value = $(this).val();
        hideSuboptions();
        switch (value) {
            case "gender":
                showSubOption('#gender, #display-number');
                break;
            case "role":
                showSubOption('#role, #display-number');
                break;
        }
    });
</script>