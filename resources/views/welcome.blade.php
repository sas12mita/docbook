<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Doctor Appointment System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Grid layout for the cards */
        .doctors-list {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 cards per row */
            gap: 20px;
            padding: 20px;
            margin-top:50px;
        }

        /* Doctor card styling */
        .doctor-card {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .doctor-card:hover {
            transform: translateY(-10px);
        }

        .doctor-card h3 {
            margin-top: 0;
            font-size: 1.2em;
            color: #333;
        }

        .doctor-card p {
            margin: 5px 0;
            color: #555;
        }

        .doctor-card strong {
            color: #333;
        }

        /* Responsive layout for smaller screens */
        @media (max-width: 1024px) {
            .doctors-list {
                grid-template-columns: repeat(3, 1fr); /* 3 cards per row */
            }
        }

        @media (max-width: 768px) {
            .doctors-list {
                grid-template-columns: repeat(2, 1fr); /* 2 cards per row */
            }
        }

        @media (max-width: 480px) {
            .doctors-list {
                grid-template-columns: 1fr; /* 1 card per row */
            }
        }
    </style>
    </style>
</head>
<body class="bg-blue-50">

    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-6 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-blue-600">HealthCare+</a>
            <div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-blue-600 font-semibold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-blue-600 font-semibold mr-4">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-500">Sign up</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main class="py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold text-blue-700">Your Health, Our Priority</h1>
            <p class="text-lg text-gray-600 mt-4">Book an appointment with the best doctors in town and receive top-notch healthcare.</p>
            <div class="mt-8">
                <a class="bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-500">List Of Doctor</a>
            </div>
        </div>
        <div class="doctors-list">
        @foreach ($doctors as $doctor)
            <div class="doctor-card">
                <img src="https://media.istockphoto.com/id/177373093/photo/indian-male-doctor.jpg?s=612x612&w=0&k=20&c=5FkfKdCYERkAg65cQtdqeO_D0JMv6vrEdPw3mX1Lkfg="
                height="100px";>
                <h3 style="color:green;font-weight:799"><center>{{ $doctor->user->name }}</center></h3>
                <p><strong>Specialization:</strong> {{ $doctor->specialization->name ?? 'General' }}</p>
                <p><strong>Address:</strong> {{ $doctor->user->address }}</p>
                <p><strong>Phone Number:</strong> {{ $doctor->user->phone}}</p>
            </div>
        @endforeach
    </main>

    <footer class="bg-white py-6 mt-16">
        <div class="container mx-auto text-center">
            <p class="text-gray-500"> HealthCare+. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
