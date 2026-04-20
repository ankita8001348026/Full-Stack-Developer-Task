<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>

<body>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h4>Update Password</h4>
            </div>
            <div class="card-body">

                <form action="javascript:void(0)" method="POST" id="password_form">
                    @csrf
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter new password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="Confirm new password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" id="update_password">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $("#update_password").click(() => {
            $.ajax({
                url: "{{route('backend.update.password')}}",
                type: "post",
                data: {
                    _token: '{{csrf_token()}}',
                    id: '{{$id}}',
                    password: $("#password").val(),
                    password_confirmation: $("#password_confirmation").val(),
                },
                success: function (response) {
                    if (response.status == 'error') {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: response.msg
                        });
                    } else {
                        $("#password_form")[0].reset();
                        Swal.fire({
                            title: "Done!",
                            text: response.msg,
                            icon: "success"
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        })

    </script>
</body>

</html>