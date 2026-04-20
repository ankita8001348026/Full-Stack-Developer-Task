@extends('backend.layouts.main')
@section('title', 'Create')
@section('sections')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('backend.project-status.index', ['project' => $project_id]) }}">Project
                                    Status</a>
                            </li>
                            <li class="breadcrumb-item active">Create</li>
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

                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-sm btn-secondary"
                            href="{{ route('backend.project-status.index', ['project' => $project_id]) }}">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                    </div>
                    <form action="{{ route('backend.project-status.store') }}" method="POST" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="card-body">
                            <input type="hidden" name="project_id" value="{{ $project_id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control select2bs4" name="status">
                                            <option value="1" @selected(old('status', $status->status) == 1) {{ $status->status == 1 ? 'disabled' : '' }}>
                                                Approved
                                            </option>

                                            <option value="2" @selected(old('status', $status->status) == 2) {{ $status->status == 2 ? 'disabled' : '' }}>
                                                Rejected
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="note">Note</label>
                                        <textarea class="form-control" id="note" name="note"
                                            placeholder="Enter note">{{ old('note') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {

                // Summernote
                $('#description').summernote()
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
            });
        </script>
    @endpush
@endsection