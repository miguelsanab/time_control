<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Form</title>
    
    <!-- Estilos CSS personalizados -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .card-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .text-center {
            text-align: center;
        }

        h3 {
            margin: 0;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card-header text-center">
            <h3>Register</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input id="name" type="text" class="form-control" name="name" required autofocus>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" class="form-control" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn">Register</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
