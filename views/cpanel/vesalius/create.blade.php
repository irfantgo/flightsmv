@extends('cpanel.cpanel')
@section('page_title', 'Vesalius Reports')
@section('page_content')


<form action="/reports-ves/store" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/reports-ves">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Basic Information
                </div>
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Use a meaningful title" autocomplete="off" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Write a short description for the query" autocomplete="off" >
                    </div>
                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Query Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <textarea class="form-control match_sql_statement" id="query_statement" name="query_statement" placeholder="Write your SQL Query here" autocomplete="off" rows="12" ></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <table id="input_table" class="table table-bordered"></table>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="row">
                        <div class="col-lg-12">
                            <a href="/reports-ves/querytest" class="btn btn-default query-test-button">Test Query</a>
                        </div>
                    </div>
                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Recipients
                </div>
                <div class="card-body">
                    @if (empty($recipients))
                        <p>No Active Recipients</p>
                    @else
                        <table class="table table-bordered">
                            @foreach ($recipients as $person)
                            <tr>
                                <td width="40"><input type="checkbox" id="recipient-{{ $person['ID'] }}" name="recipients[]"><input type="hidden" id="recipients"></td>
                                <td>{{ $person['full_name'] }} ({{ $person['email'] }})</td>
                            </tr>
                            @endforeach
                        </table>
                        
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Scheduled
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label" for="rec">Recurrance</label>
                        <select name="rec" id="rec" class="select2 form-control">
                            <option value="D">Daily</option>
                            <option value="M">Monthly</option>
                            <option value="Y">Yearly</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="run_t">Run Time</label>
                        <input type="text" class="form-control datetimepicker-input timepicker" id="run_t" name="run_t" autocomplete="off" >
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    {{ csrf() }}

    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Create</button>
            <a href="/reports-ves" class="btn btn-flat">Cancel</a>
        </div>
    </div>

</form>

<div class="modal fade show" id="query-display" aria-modal="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Query Results</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Loading...</div>
        </div>
    </div>
</div>

@endsection