<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors in Specialization</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5rem;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .doctor-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .doctor-item {
            background-color: #ffffff;
            padding: 25px;
            border: 1px solid #ddd;
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .doctor-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .doctor-item strong {
            font-size: 1.2rem;
            color: #3498db;
        }

        .doctor-item p {
            font-size: 1rem;
            margin: 12px 0;
            color: #777;
        }

        .doctor-item .email {
            color: #3498db;
            font-size: 1rem;
            text-decoration: none;
        }

        .doctor-item .email:hover {
            text-decoration: underline;
        }

        .view-schedule-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 15px;
            font-size: 1rem;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .view-schedule-btn:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .schedule-list {
            margin-top: 20px;
            display: none;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 12px;
        }

        .schedule-item {
            padding: 12px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            border-radius: 8px;
            background-color: #fff;
        }

        .schedule-item strong {
            font-size: 1rem;
            color: #2c3e50;
        }

        .schedule-item .book-appointment-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2ecc71;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 10px;
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .schedule-item .book-appointment-btn:hover {
            background-color: #27ae60;
            transform: scale(1.05);
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
            <div class="doctor-item">
                <strong>Doctor Name:</strong> {{ $doctor->user->name }}<br>
                <strong>Email:</strong> <a href="mailto:{{ $doctor->user->email }}" class="email">{{ $doctor->user->email }}</a>

                <!-- View Schedule Button -->
                <button class="view-schedule-btn" data-doctor-id="{{ $doctor->id }}">View Schedule</button>

                <!-- Hidden Schedule List -->
                <div class="schedule-list" id="schedule-list-{{ $doctor->id }}" style="display: none;"></div>
            </div>
            @empty
            <p class="empty-message">No doctors available for this specialization.</p>
            @endforelse
        </div>
    </div>

    <!-- AJAX Script -->
    <script>
        document.querySelectorAll('.view-schedule-btn').forEach(button => {
            button.addEventListener('click', function() {
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
                                        <div class="schedule-item">
                                            <strong>Date:</strong> ${schedule.date}<br>
                                            <strong>Day:</strong> ${schedule.day}<br>
                                            <strong>Start Time:</strong> ${schedule.start_time}<br>
                                            <strong>End Time:</strong> ${schedule.end_time}<br>
                                            <button class="book-appointment-btn"
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
                                    bookButton.addEventListener('click', function() {
                                        const doctorId = this.getAttribute('data-doctor-id');
                                        const appointmentDate = this.getAttribute('data-appointment-date');
                                        const startTime = this.getAttribute('data-start-time');
                                        const endTime = this.getAttribute('data-end-time');

                                        // Redirect to the appointment create page with parameters
                                        console.log(doctorId);
                                        const url = `/appointments/create/${doctorId}`;
                                        window.location.href = url; // Redirecting to the route
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
