@extends('backend.layouts.main')
@section('title', 'Dashboard')

@section('sections')
    <div class="content-wrapper">

        {{-- Page Header --}}
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                {{-- Stat Cards --}}
                <div class="row">

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $data['total_projects'] }} ({{ $data['total_projects_percent'] }}%)</h3>
                                <p>Total Submitted Projects</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $data['pending_projects'] }} ({{ $data['pending_projects_percent'] }}%)</h3>
                                <p>Total Pending Projects</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $data['rejected_projects'] }} ({{ $data['rejected_projects_percent'] }}%)</h3>
                                <p>Total Rejected Projects</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $data['approved_projects'] }} ({{ $data['approved_projects_percent'] }}%)</h3>
                                <p>Total Approved Projects</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Project List</h3>
                    </div>
                    <div class="card card-outline card-primary">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <form role="form" autocomplete="off">

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg">
                                                    <div class="form-group">
                                                        <label>Submission date</label>
                                                        <input type="text" name="submission_date"
                                                            class="form-control js-daterange-picker"
                                                            placeholder="Select Date Range">
                                                        <input type="hidden" name="start_date" class="form-control">
                                                        <input type="hidden" name="end_date" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-lg">
                                                    <div class="form-group">
                                                        <label>Project status</label>
                                                        <select class="form-control select2bs4" name="project_status">
                                                            <option value="">---Select---</option>
                                                            <option value="0">Pending</option>
                                                            <option value="1">Approved</option>
                                                            <option value="2">Rejected</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg">
                                                    <div class="form-group">
                                                        <label>Submitter</label>
                                                        <input type='text' name="submitter" class="form-control"
                                                            placeholder="Search by name,email..." />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row align-items-center mt-2">
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-sm bg-gradient-danger"
                                                        id="btn_clear">Clear
                                                    </button>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-sm bg-gradient-info float-right"
                                                        id="btn_filter">
                                                        <i class="fa fa-filter m-r-5"></i> Filter
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-outline card-primary">
                        <div class="card-body p-0">
                            <table id="table" class="table m-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Project name</th>
                                        <th>Submitter details</th>
                                        <th>Submission date</th>
                                        <th>Current status</th>
                                        <th>Last updated timestamp</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- End Stat Cards --}}

            </div>
        </section>
    </div>
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {

                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
                $('.js-daterange-picker').daterangepicker({
                    showDropdowns: true,
                    autoUpdateInput: false,
                    applyClass: "btn-primary",
                    locale: {
                        format: 'DD-MM-YYYY',
                        separator: "-",
                        cancelLabel: 'Clear'
                    }
                }, function (start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                        'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                }).on('apply.daterangepicker', function (ev, picker) {
                    if (moment(picker.startDate.format('YYYY-MM-DD')).isSame(picker.endDate.format(
                        'YYYY-MM-DD'))) {
                        $(this).val(picker.startDate.format('DD-MM-YYYY'));
                    } else {
                        $(this).val(picker.startDate.format('DD-MM-YYYY') + '  -  ' + picker.endDate.format(
                            'DD-MM-YYYY'));
                    }

                    $('input[name="start_date"]').val(picker.startDate.format('YYYY-MM-DD'));
                    $('input[name="end_date"]').val(picker.endDate.format('YYYY-MM-DD'));
                }).on('cancel.daterangepicker', function (ev, picker) {
                    $(this).val('');
                    $('input[name="start_date"]').val('');
                    $('input[name="end_date"]').val('');
                });

                // Search
                $('#btn_filter').click(function (e) {
                    table.draw(false);
                });

                // Clear
                $('#btn_clear').click(function (e) {
                    $('input[name="submission_date"]').val('');
                    $('.js-daterange-picker').data('daterangepicker').setStartDate(moment().format(
                        'DD/MM/YYYY'));
                    $('.js-daterange-picker').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
                    $('input[name="start_date"]').val('');
                    $('input[name="end_date"]').val('');


                    $('select[name="project_status"]').val('').trigger('change');
                    $('input[name="submitter"]').val('');

                    table.draw(false);
                });

                var table = $('#table').DataTable({
                    dom: '<"pl-2 pt-2 pr-2 pb-2" <"row" <"col-lg-6" l><"col-lg-3" f><"col-lg-3 text-right" B>> > rt <"border-top pl-2 pt-2 pr-2 pb-2 " <"row" <"col-lg-6" i><"col-lg-6" p>> >',
                    buttons: [],
                    lengthChange: false,
                    searching: false,
                    info: true,
                    paging: true,
                    searchHighlight: false,
                    ordering: false,
                    autoWidth: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    stateSave: false,
                    deferRender: true,
                    pageLength: 10,
                    order: false,
                    columnDefs: [{
                        orderable: false,
                        targets: [0, 1, 2, 3, 4, 5]
                    },
                    {
                        className: 'text-center',
                        targets: [0, 1, 2, 3, 4, 5]
                    },
                    {
                        width: '50px',
                        targets: 5
                    }
                    ],
                    ajax: {
                        url: '{{ route('backend.dashboard') }}',
                        dataType: 'json',
                        type: 'GET',
                        data: function (d) {
                            d.start_date = $('input[name="start_date"]').val();
                            d.end_date = $('input[name="end_date"]').val();
                            d.project_status = $('select[name="project_status"]').val();
                            d.submitter = $('input[name="submitter"]').val();
                        }
                    },
                    columns: [{
                        data: 'id'
                    }, {
                        data: 'title'
                    }, {
                        data: 'submitter'
                    }, {
                        data: 'submission_date'
                    }, {
                        data: 'status'
                    }, {
                        data: 'last_updated_timestamp'
                    }]
                });
            });
        </script>
    @endpush
@endsection