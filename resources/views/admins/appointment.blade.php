<x-app-layout>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Appointments</title>
        <style>
            .container {
                max-width: 1000px;
                margin: 20px auto;
                padding: 20px;
                background-color: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            table th,
            table td {
                padding: 12px;
                text-align: left;
                border: 1px solid #ddd;
            }

            table th {
                background-color: #007bff;
                color: #fff;
            }

            .empty-message {
                text-align: center;
                color: #666;
                font-size: 1.2em;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h2 class="text-center">Appointments</h2>

            @if($appointments->isEmpty()) <!-- Corrected the variable name -->
                <p class="empty-message">No appointments found.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Doctor Name</th>
                            <th>Patient Name</th>
                            <th>Appointment Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $appointment->doctor->user->name ?? 'N/A' }}</td>
                                <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                                <td>{{ $appointment->appointment_date }}</td>
                                <td>{{ $appointment->start_time }}</td>
                                <td>{{ $appointment->end_time }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </body>

</x-app-layout>
