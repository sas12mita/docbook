<x-app-layout>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Schedule</title>
    <style>
        /* General Container Styling */
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
        }

        /* Header */
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Appointment List Styling */
        .appointment-list {
            margin-top: 20px;
        }

        .appointment-item {
            background-color: #f4f7fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .appointment-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        /* Strong Text */
        strong {
            color: #333;
            font-weight: 600;
        }

        /* Email Link */
        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* No Appointments Message */
        p {
            color: #777;
            text-align: center;
            font-size: 16px;
        }

        /* Button Styling */
        button,
        .btn-update,
        .btn-delete {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: bold;
            margin-left: 10px;
        }

        /* Blue Button - Update */
        .btn-update {
            background-color: #007bff;
            color: #fff;
        }

        .btn-update:hover {
            background-color: #0056b3;
        }

        /* Green Button - Delete */
        .btn-delete {
            background-color: #28a745;
            color: #fff;
        }

        .btn-delete:hover {
            background-color: #218838;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .appointment-item {
                padding: 10px;
            }
        }
    </style>


    <div class="container">
        <h2 style="color: #007bff; text-align: center; font-family: Arial, sans-serif; font-size: 24px;">My Appointments</h2>

        @if ($appointments->isEmpty())
            <p>No appointments found.</p>
        @else
            <div class="button-container">
                <a href="{{ route('specializations.patient') }}" class="btn" style="display: inline-block; padding: 8px 21px; background-color: #0844ff; color: white; border-radius: 5px; text-decoration: none; font-weight: bold; transition: background-color 0.3s ease;">
                    <i class="fas fa-calendar-alt"></i> View Schedule
                </a>
            </div>

            <div class="appointment-list">
                @foreach ($appointments as $appointment)
                <div class="appointment-item">
                    <div>
                        <strong>Doctor:</strong> {{ $appointment->doctor->user->name }}<br>
                        <strong>Email:</strong>
                        <a href="mailto:{{ $appointment->doctor->user->email }}">
                            {{ $appointment->doctor->user->email }}
                        </a><br>
                        <strong>Date:</strong> {{ $appointment->appointment_date }}<br>
                        <strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                    </div>
                    
                    @if($appointment->status == 'pending')
                    <div style="color:red"><button>pending</button></div>
                    @else
                    <div style="background-color:lightgreen"><button>approved</button></div>
                    @endif
                </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
