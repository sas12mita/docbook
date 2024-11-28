<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Listings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

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
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-blue-700 text-center mb-8">Our Doctors</h1>
        
        <!-- Grid layout for the doctor cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($doctors as $doctor)
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-center text-green-600 text-xl font-semibold mt-4">{{ $doctor->user->name }}</h3>
                    <p class="text-gray-600 mt-2"><strong>Specialization:</strong> {{ $doctor->specialization->name ?? 'General' }}</p>
                    <p class="text-gray-600 mt-2"><strong>Address:</strong> {{ $doctor->user->address }}</p>
                    <p class="text-gray-600 mt-2"><strong>Phone Number:</strong> {{ $doctor->user->phone }}</p>
                </div>
            @endforeach
        </div>

        <!-- Pagination links -->
        <div class="mt-8 text-center">
            {{ $doctors->links() }} <!-- This will generate pagination controls -->
        </div>
    </div>
</main>

</body>
</html>
