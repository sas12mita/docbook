<x-app-layout>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Schedule</title>
    <style>
        /* General Container Styling */
        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .appointment-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .appointment-item {
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .appointment-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .appointment-item strong {
            color: #333;
        }

        .appointment-item p {
            margin: 0;
            color: #555;
        }

        .button-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .btn-completed {
            background-color: #28a745;
            color: #fff;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-completed:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .no-appointments {
            text-align: center;
            color: #888;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>

    <div class="container">
        <h2>My Appointments</h2>

        @if ($appointmentsdoctor->isEmpty())
        <p class="no-appointments">No appointments scheduled.</p>
        @else
        <div class="appointment-list">
            @foreach ($appointmentsdoctor as $appointment)
            <div class="appointment-item">
                <strong>Patient Name:</strong> {{ optional($appointment->patient)->name ?? 'N/A' }}<br>
                <strong>Email:</strong> <a href="mailto:{{ optional($appointment->patient)->email ?? '' }}" style="color: #007bff;">{{ optional($appointment->patient)->email ?? 'N/A' }}</a>
                <div class="button-row">
                    @if($appointment->status=='pending')
                    <form  action="{{ route('appointments.status') }}" method="POST">
                        @csrf
                        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                        <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg" style="padding: 8px 20px; font-size: 1.2rem; color:white;border-radius: 50px; background-color: green; transition: background-color 0.3s ease;">
                        Approve
                    </button>
                </div>

                    </form>
                    @else
                    <button type="submit" class="btn btn-primary btn-lg" style="padding: 8px 20px; font-size: 1.2rem; color:white;border-radius: 50px; background-color: blue; transition: background-color 0.3s ease;">
                        Approved
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</x-app-layout>
