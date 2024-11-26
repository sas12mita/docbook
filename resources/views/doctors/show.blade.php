<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors in Specialization</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2rem;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }

        .doctor-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .doctor-item {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .doctor-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .doctor-item strong {
            font-size: 1.2rem;
            color: #007bff;
        }

        .doctor-item p {
            font-size: 1rem;
            margin: 10px 0;
            color: #666;
        }

        .doctor-item .email {
            color: #007bff;
            font-size: 1rem;
            text-decoration: none;
        }

        .doctor-item .email:hover {
            text-decoration: underline;
        }

        .view-schedule-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .view-schedule-btn:hover {
            background-color: #0056b3;
        }

        .schedule-list {
            margin-top: 20px;
            display: none;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
        }

        .schedule-item {
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .empty-message {
            text-align: center;
            color: #e74c3c;
            font-size: 1.2rem;
        }
    </style>
</head>
<x-app-layout>
    <div class="container mt-5">
        <h1 class="text-center">Doctors in Specialization: {{ $specialization->name }}</h1>

        <div class="doctor-list">
            @forelse($doctors as $doctor)
                <div class="doctor-item mb-4 p-3 border rounded">
                    <strong>Doctor Name:</strong> {{ $doctor->user->name }}<br>
                    <strong>Email:</strong> <a href="mailto:{{ $doctor->user->email }}" class="email">{{ $doctor->user->email }}</a>

                    <!-- View Schedule Button -->
                    <button class="view-schedule-btn btn btn-primary mt-3" data-doctor-id="{{ $doctor->id }}">View Schedule</button>

                    <!-- Hidden Schedule List -->
                    <div class="schedule-list mt-3" id="schedule-list-{{ $doctor->id }}" style="display: none;"></div>
                </div>
            @empty
                <p class="text-center">No doctors available for this specialization.</p>
            @endforelse
        </div>
    </div>

    <!-- Appointment Form -->
    <div class="container mt-5" id="appointment-form-container" style="display: none;">
        <h2 class="text-center">Book an Appointment</h2>
        <form action="{{ route('appointments.store') }}" method="POST" class="p-4 shadow-sm rounded" style="background-color: #f9f9f9;">
            @csrf

            <!-- Hidden Doctor ID -->
            <input type="hidden" id="doctor_id" name="doctor_id" value="">

            <!-- Appointment Date -->
            <div class="mb-3">
                <label for="appointment_date" class="form-label"><strong>Appointment Date:</strong></label>
                <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
            </div>

            <!-- Start Time -->
            <div class="mb-3">
                <label for="start_time" class="form-label"><strong>Start Time:</strong></label>
                <input type="time" class="form-control" id="start_time" name="start_time" required>
            </div>

            <!-- End Time -->
            <div class="mb-3">
                <label for="end_time" class="form-label"><strong>End Time:</strong></label>
                <input type="time" class="form-control" id="end_time" name="end_time" required>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg">Book Appointment</button>
            </div>
        </form>
    </div>

    <!-- AJAX Script -->
    <script>
        document.querySelectorAll('.view-schedule-btn').forEach(button => {
            button.addEventListener('click', function () {
                const doctorId = this.getAttribute('data-doctor-id');
                const scheduleList = document.getElementById(`schedule-list-${doctorId}`);

                if (scheduleList.style.display === 'block') {
                    scheduleList.style.display = 'none';
                } else {
                    fetch(`/doctors/${doctorId}/schedule`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.schedules.length > 0) {
                                let scheduleHTML = '';
                                data.schedules.forEach(schedule => {
                                    scheduleHTML += `
                                        <div class="schedule-item mb-3">
                                            <strong>Date:</strong> ${schedule.date}<br>
                                            <strong>Day:</strong> ${schedule.day}<br>
                                            <strong>Start Time:</strong> ${schedule.start_time}<br>
                                            <strong>End Time:</strong> ${schedule.end_time}<br>
                                            <button class="book-appointment-btn btn btn-success mt-2"
                                                data-doctor-id="${doctorId}" 
                                                data-appointment-date="${schedule.date}" 
                                                data-start-time="${schedule.start_time}" 
                                                data-end-time="${schedule.end_time}">
                                                Book Appointment
                                            </button>
                                        </div>`;
                                });
                                scheduleList.innerHTML = scheduleHTML;

                                // Add event listeners for "Book Appointment" buttons
                                document.querySelectorAll('.book-appointment-btn').forEach(bookButton => {
                                    bookButton.addEventListener('click', function () {
                                        const doctorId = this.getAttribute('data-doctor-id');
                                        const appointmentDate = this.getAttribute('data-appointment-date');
                                        const startTime = this.getAttribute('data-start-time');
                                        const endTime = this.getAttribute('data-end-time');

                                        // Populate the appointment form
                                        document.getElementById('doctor_id').value = doctorId;
                                        document.getElementById('appointment_date').value = appointmentDate;
                                        document.getElementById('start_time').value = startTime;
                                        document.getElementById('end_time').value = endTime;

                                        // Show and scroll to the form
                                        document.getElementById('appointment-form-container').style.display = 'block';
                                        document.getElementById('appointment-form-container').scrollIntoView({ behavior: 'smooth' });
                                    });
                                });
                            } else {
                                scheduleList.innerHTML = '<p>No schedules available.</p>';
                            }
                            scheduleList.style.display = 'block';
                        })
                        .catch(error => {
                            console.error('Error fetching schedule:', error);
                        });
                }
            });
        });
    </script>
</x-app-layout>


</html>