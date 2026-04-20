@extends('backend.layouts.main')
@section('title', 'Create customer')
@section('sections')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Customer</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.customers.index') }}">Customers</a>
                            </li>
                            <li class="breadcrumb-item active">Create Customer</li>
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
                        <a class="btn btn-sm btn-secondary" href="{{ route('backend.customers.index') }}">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                    </div>
                    <form action="{{ route('backend.customers.store') }}" method="POST" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            placeholder="Enter first name" value="{{ old('first_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="middle_name">Middle Name</label>
                                        <input type="text" class="form-control" id="middle_name" name="middle_name"
                                            placeholder="Enter middle name" value="{{ old('middle_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            placeholder="Enter last name" value="{{ old('last_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Enter email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="number">Mobile Number</label>
                                        <input type="number" class="form-control" id="number" name="number"
                                            placeholder="Enter mobile number" value="{{ old('number') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="avatar">Gender</label>
                                    <div class="form-group d-flex">
                                        <div class="form-check mr-3 ml-3">
                                            <input class="form-check-input" type="radio" id="male" name="gender"
                                                @if (old('gender') == '1') checked @endif value="1">
                                            <label class="form-check-label" for="male">Male</label>
                                        </div>
                                        <div class="form-check mr-3 ml-3">
                                            <input class="form-check-input" type="radio" id="female" name="gender"
                                                @if (old('gender') == '2') checked @endif value="2">
                                            <label class="form-check-label" for="female">Female</label>
                                        </div>
                                        <div class="form-check mr-3 ml-3">
                                            <input class="form-check-input" type="radio" id="other" name="gender"
                                                @if (old('gender') == '3') checked @endif value="3">
                                            <label class="form-check-label" for="other">Other</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" name="status">
                                            <option value="" hidden>Select status</option>
                                            <option value="1" @if (old('status') == '1') selected @endif>Active
                                            </option>
                                            <option value="0" @if (old('status') == '0') selected @endif>
                                                Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Enter password" value="{{ old('password') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h4><b>Add Address</b></h4>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="block">Block</label>
                                        <input type="text" class="form-control" id="block" name="block"
                                            placeholder="Enter block" value="{{ old('block') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="street">Street</label>
                                        <input type="text" class="form-control" id="street" name="street"
                                            placeholder="Enter street" value="{{ old('street') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="house_number">House number</label>
                                        <input type="text" class="form-control" id="house_number" name="house_number"
                                            placeholder="Enter house number" value="{{ old('house_number') }}">
                                    </div>
                                </div>
                                {{-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="apartment">Apartment</label>
                                        <input type="text" class="form-control" id="apartment" name="apartment"
                                            placeholder="Enter apartment" value="{{ old('apartment') }}">
                                    </div>
                                </div> --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="floor">Floor</label>
                                        <input type="text" class="form-control" id="floor" name="floor"
                                            placeholder="Enter floor" value="{{ old('floor') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="other">Jadda</label>
                                        <input type="text" class="form-control" id="jadda" name="jadda"
                                            placeholder="Enter jadda" value="{{ old('other') }}">
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
        <script>
            $(document).ready(function() {
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
            });
        </script>
    @endpush
@endsection
