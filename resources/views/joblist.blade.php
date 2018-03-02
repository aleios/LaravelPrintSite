@extends('layouts.app')

@section('content')
    <h2>Printing Jobs</h2>

    <!-- Filters menu -->
    <div class="panel-group" id="accordion" role="tablist">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" data-target="#filters">Filters</a>
                </h4>
            </div>

            <div id="filters" class="panel-collapse collapse in">
                <div class="panel-body">
                    {!! Form::label('jobfilter', 'Filter: ') !!}
                    {!! Form::text('jobfilter') !!}

                    <br />
                    {!! Form::label('statusfilter', 'Status:') !!}
                    {!! Form::select('statusfilter', $statusCodes) !!}

                    <br />
                    {!! Form::button('Apply Filters', array('id' => 'btnApplyFilters')) !!}
                </div>
            </div>

        </div>
    </div>

    <div id="results">

        
    </div>

    <div id="pagination">
        <ul class="pagination" id="pages">
        </ul>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        var statusCode = 0;
        var filter = "";
        var dataRequest;
        var ajaxPage = {{ $page }};
        $(document).ready(function() {

            PerformAjax();

            // React to change of status code.
            $("#statusfilter").on('change', function() {
                statusCode = this.value;
                PerformAjax();
            });

            $("#jobfilter").on('input propertychange paste', function() {
                filter = this.value;
                PerformAjax();
            });

            $("#btnApplyFilters").click(function(){
                PerformAjax();
            });

            $('body').on('click', '.pagination a', function(e) {
                e.preventDefault();

                var url = $(this).attr('href');

                $.ajax({
                    url: url,
                    statusCode: statusCode,
                    filter: filter
                }).done(function(data) {
                    $("#results").empty().html(data);
                });
            });
        });

        function PerformAjax()
        {
            $.ajax({
                url: "{{ URL::to('jobs/read-data') }}",
                type: "get",
                data: {
                    pageid: ajaxPage,
                    statusCode: statusCode,
                    filter: filter
                }
            }).done(function(data) {
                $("#results").empty().html(data);
                
            }).fail(function(jqXHR, textStatus) {
                
            });
        }
    </script>
@endsection