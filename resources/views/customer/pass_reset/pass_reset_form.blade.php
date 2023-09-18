<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">


    <title>Reset Password</title>
</head>

<body>

    <div class="container" style="margin-top: 100px;">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-header bg-dark">
                    <h3 class="text-white text-center">Reset Your Password</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('pass.reset.confirm') }}" method="POST">
                        @csrf

                        @if (session('match'))
                            <div class="alert alert-danger">
                                {{ session('match') }}
                            </div>
                        @endif


                        @if (session('pass_reset'))
                            <div class="alert alert-success">
                                {{ session('pass_reset') }}
                            </div>
                        @endif

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>


                        <div class="form-group mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirm Password">
                        </div>

                        <div class="form-group mb-3">
                            <button class="btn btn-dark" type="submit">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>

</body>

</html>
