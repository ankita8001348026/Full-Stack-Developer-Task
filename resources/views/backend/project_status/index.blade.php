@extends('backend.layouts.main')
@section('title', 'Project')
@section('sections')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark">Project</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Project</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        @include('backend.common.message')
                    </div>
                </div>

                <div class="card card-outline card-primary">
                    <div class="card-body p-0">
                        <table id="table" class="table m-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {

                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })


                var table = $('#table').DataTable({
                    dom: '<"pl-2 pt-2 pr-2 pb-2" <"row" <"col-lg-6" l><"col-lg-3" f><"col-lg-3 text-right" B>> > rt <"border-top pl-2 pt-2 pr-2 pb-2 " <"row" <"col-lg-6" i><"col-lg-6" p>> >',
                    buttons: [{
                        text: '<i class="fa fa-plus-circle"></i>',
                        className: 'btn btn-sm btn-success datatable-button',
                        action: function (e, dt, node, config) {
                            window.location.href = '{{ route('backend.project-status.create', ['project' => $project]) }}';
                        }
                    }],
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
                        targets: [0, 1, 2]
                    },
                    {
                        className: 'text-center',
                        targets: [0, 1, 2]
                    },
                    {
                        width: '30px',
                        targets: 2
                    }
                    ],
                    ajax: {
                        url: '{{ route('backend.project-status.index', ['project' => $project]) }}',
                        dataType: 'json',
                        type: 'GET',
                    },
                    columns: [{
                        data: 'title'
                    }, {
                        data: 'note'
                    }, {
                        data: 'status'
                    }]
                });
            });
        </script>
    @endpush
@endsection