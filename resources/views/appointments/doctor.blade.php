<x-app-layout>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Schedule</title>
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        input[type="time"],
        select,
        button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
    <div class="container mt-5">
        <h2 class="text-center">My Appointments</h2>

        @if ($appointments->isEmpty())
            <p class="text-center">No appointments scheduled.</p>
        @else
            <div class="appointment-list">
                @foreach ($appointments as $appointment)
                    <div class="appointment-item shadow-sm p-3 mb-3 rounded" style="background-color: #f9f9f9;">
                        <strong>Patient Name:</strong> {{ optional($appointment->patient)->name ?? 'N/A' }}<br>
                        <strong>Email:</strong> 
                        <a href="mailto:{{ optional($appointment->patient)->email ?? '#' }}">
                            {{ optional($appointment->patient)->email ?? 'N/A' }}
                        </a><br>
                        <strong>Date:</strong> {{ $appointment->appointment_date }}<br>
                        <strong>Time:</strong> {{ $appointment->start_time }} - {{ $appointment->end_time }}
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
