
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'RBAC Management System') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AdminLTE -->
    <link href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg,#4e73df,#36b9cc,#1cc88a);
            min-height:100vh;
        }

        .login-card{
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 15px 35px rgba(0,0,0,.2);
        }

        .login-header{
            background:#007bff;
            color:#fff;
            padding:25px;
            text-align:center;
        }

        .login-header i{
            font-size:55px;
            margin-bottom:10px;
        }

        .btn-login{
            border-radius:10px;
            font-weight:600;
        }

        .form-control{
            border-radius:10px;
        }

        .input-group-text{
            border-radius:0 10px 10px 0;
        }
    </style>

</head>

<body class="hold-transition">

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height:100vh;">

        <div class="col-md-5">

            <div class="card login-card">

                <div class="login-header">
                    <i class="fas fa-user-shield"></i>
                    <h3>RBAC Management System</h3>
                    <p class="mb-0">Login to continue</p>
                </div>

                <div class="card-body">

                    {{ $slot }}

                </div>

            </div>

        </div>

    </div>
</div>

</body>
</html>

