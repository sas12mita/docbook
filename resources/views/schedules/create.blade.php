<x-app-layout>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto-fill Day Based on Date</title>
    <style>
        .forms {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group input:focus {
            border-color: #007bff;
            outline: none;
        }

        .form-button {
            text-align: center;
        }

        .form-button button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-button button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="forms">
    <div class="form-container">
    <form action="{{ route('schedules.store') }}" method="POST">
    @csrf
    <input type="hidden" name="doctor_id" value="{{ Auth::id() }}"> <!-- Assuming logged-in user is the doctor -->

            <div class="form-group">
                <label for="date">Select Date</label>
                <input type="date" id="date" name="date" required onchange="autoFillDay()">
            </div>
            <div class="form-group">
                <label for="day">Day</label>
                <input type="text" id="day" name="day" readonly placeholder="Day will auto-fill">
            </div>
            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" id="start_time" name="start_time" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="time" id="end_time" name="end_time" required>
            </div>
            <div class="form-button">
                <button type="submit">Submit</button>
            </div>
        </form>
        </div>
    </div>

    <script>
        /**
         * Auto-fill the day input field based on the selected date.
         */
        function autoFillDay() {
            const dateInput = document.getElementById('date').value; // Get selected date
            const dayField = document.getElementById('day'); // Day input field
            if (dateInput) {
                const date = new Date(dateInput); // Convert to Date object
                const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                const dayName = days[date.getDay()]; // Get day of the week
                dayField.value = dayName; // Set value in the day field
            } else {
                dayField.value = ''; // Clear field if no date is selected
            }
        }
    </script>
</body>
</x-app-layout>
