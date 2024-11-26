<x-app-layout>
    <head>
        <style>
            .container{
                height: auto;
                padding:30px;
                display: flex;
                justify-content: center;
                gap:10px;
            }
            .btn{
                background-color: cornflowerblue;
                padding: 20px;
            }
        </style>
    </head>
    <br>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <!-- <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            font-size: 24px;
            color: #333;
        }
        .info {
            margin-top: 20px;
        }
        .info p {
            font-size: 18px;
            color: #555;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style> -->
</head>
<body>
    <div class="container">
        <h1>Welcome to Your Dashboard</h1>

        <!-- <div class="info">
            <p>Your name: <strong>{{ $user->name }}</strong></p>
            <p>Your address: <strong>{{ $user->address ?? 'No address provided' }}</strong></p>
            <p>Your phone number: <strong>{{ $user->phone_number ?? 'No phone number provided' }}</strong></p>
        </div> -->
    </div>
</body>
</html>

    <div class="container">
    <a href="{{ route('specializations.patient') }}" class="btn">View Schedule</a>
    <a href="{{ route('appointments.patient') }}" class="btn">View Appointment</a>
    </div>

</x-app-layout>