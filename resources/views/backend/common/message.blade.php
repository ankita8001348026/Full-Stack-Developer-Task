@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('success'))
    <div class="alert alert-success">
        <strong> {{ session('success') }} </strong>
    </div>
@endif

@if (session()->has('danger'))
    <div class="alert alert-danger">
        <strong> {{ session('danger') }} </strong>
    </div>
@endif
