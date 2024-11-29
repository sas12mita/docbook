<x-app-layout>
    <style>
        .card {
            border-radius: 10px;
            padding:10px;
            background-color: white;
            margin-top: 20px;
        }

        .card-title {
            font-weight: bold;
        }

        .btn-outline-primary {
            transition: all 0.3s ease-in-out;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }

        span {
            color:red;
        }
    </style>
    <div class="container mt-5" style="display:flex;justify-content:space-evenly">
        <div>
            <h2 class="text-center mb-4" style="font-size: 2rem; font-weight: 600; color: #2c3e50;">Edit Appointment</h2>

            <!-- Edit Form -->
            <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="p-4 shadow-lg rounded-lg" style="background-color: #f8fafc; border: 1px solid #ddd; max-width: 600px; margin: 0 auto;">
                @csrf
                @method('PUT')

                <!-- Hidden Doctor ID -->
                <input type="hidden" id="doctor_id" name="doctor_id" value="{{ $appointment->doctor_id }}">

                <!-- Appointment Date -->
                <div class="mb-4">
                    <label for="appointment_date" class="form-label" style="font-size: 1.1rem; color: #333;"><strong>Appointment Date:</strong></label>
                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" value="{{ $appointment->appointment_date }}" required style="border-radius: 10px; padding: 10px;">
                </div>

                <!-- Start Time -->
                <div class="mb-4">
                    <label for="start_time" class="form-label" style="font-size: 1.1rem; color: #333;"><strong>Start Time:</strong></label>
                    <input type="time" class="form-control" id="start_time" name="start_time" value="{{ $appointment->start_time }}" required style="border-radius: 10px; padding: 10px;">
                </div>

                <!-- End Time -->
                <div class="mb-4">
                    <label for="end_time" class="form-label" style="font-size: 1.1rem; color: #333;"><strong>End Time:</strong></label>
                    <input type="time" class="form-control" id="end_time" name="end_time" value="{{ $appointment->end_time }}" required style="border-radius: 10px; padding: 10px;">
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg" style="padding: 12px 30px; font-size: 1.2rem; border-radius: 50px; background-color: #007bff; transition: background-color 0.3s ease;">
                        Update Appointment
                    </button>
                </div>

                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <p style="color:red"> {{ $error }}</p>
                    @endforeach
                @endif
            </form>
        </div>

    </div>

    <style>
        /* Custom Styling for the Form */
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
        }

        /* Hover effect on submit button */
        .btn:hover {
            background-color: #0056b3;
        }

        /* Add shadow and spacing */
        .container {
            padding: 30px 0;
        }

        h2 {
            font-family: 'Arial', sans-serif;
            font-weight: 700;
            color: #007bff;
        }

        .shadow-lg {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .rounded-lg {
            border-radius: 20px;
        }
    </style>
</x-app-layout>
