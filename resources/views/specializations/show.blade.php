<x-app-layout>
    <head>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #e6f0ff;
                margin: 0;
                padding: 0;
            }

            .dashboard-header {
                background-color: #1e3a8a;
                color: #fff;
                padding: 20px 0;
                text-align: center;
                border-radius: 8px 8px 0 0;
                box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            }

            .dashboard-header h1 {
                font-size: 29px;
                margin: 0;
                font-weight: 600;
                text-transform: uppercase;
            }

            .container {
                max-width: 800px;
                margin: 40px auto;
                padding: 30px;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            }

            h2 {
                color: #1e3a8a;
                font-size: 26px;
                margin-bottom: 20px;
                text-align: center;
                font-weight: 600;
            }

            p {
                color: #666;
                text-align: center;
                font-size: 16px;
                margin: 10px 0 30px;
            }

            /* Button Container */
            .button-container {
                display: flex;
                justify-content: center;
                gap: 30px;
                margin-bottom: 10px;
            }

            /* Button Styling */
            .btn {
                background-color: #1e3a8a;
                color: #fff;
                padding: 10px 20px; /* Adjusted padding for the button */
                text-decoration: none;
                font-size: 18px;
                font-weight: 600;
                border-radius: 50px;
                display: flex;
                align-items: center;
                gap: 15px;
                box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
                transform: translateY(0);
            }

            .btn:hover {
                background-color: #1e40af;
                transform: translateY(-6px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            }

            .btn i {
                font-size: 20px;
            }

            /* Patient Form Styling */
            .patient-form {
                max-width: 600px;
                margin: 50px auto;
                padding: 30px;
                background-color: #f9f9f9;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            /* Styling for form labels */
            .patient-form label {
                font-size: 1.1rem;
                font-weight: bold;
                margin-bottom: 8px;
                display: block;
            }

            /* Styling for input fields and select dropdown */
            .patient-form .form-group {
                margin-bottom: 20px;
            }

            .patient-form .form-control {
                width: 100%;
                padding: 10px;
                font-size: 1rem;
                border: 1px solid #ccc;
                border-radius: 5px;
                transition: border-color 0.3s ease;
            }

            .patient-form .form-control:focus {
                border-color: #007bff;
                outline: none;
            }

            /* Styling for the submit button */
            .patient-form .submit-btn {
                background-color: #007bff;
                color: #fff;
                font-size: 1.1rem;
                padding: 12px 20px;
                width: 100%;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            /* Hover effect for the submit button */
            .patient-form .submit-btn:hover {
                background-color: #0056b3;
            }

            /* Responsive adjustments */
            @media screen and (max-width: 768px) {
                .patient-form {
                    padding: 20px;
                }
            }
        </style>
    </head>
    <div class="container">
        <h2>Welcome to Your Dashboard</h2>
        <div class="button-container">
            <a href="{{ route('appointments.patient') }}" class="btn">
                <i class="fas fa-notes-medical"></i> View Appointments
            </a>
        </div>

        <div>
            <h2>Choose a Specialization</h2>
            <form action="{{ route('doctors.bySpecialization') }}" method="POST" class="patient-form">
                @csrf
                <div class="form-group">
                    <label for="specialization">Select Specialization:</label>
                    <select name="specialization_id" id="specialization" class="form-control" required>
                        @foreach($specializations as $specialization)
                        <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="submit-btn">Find Doctors</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
