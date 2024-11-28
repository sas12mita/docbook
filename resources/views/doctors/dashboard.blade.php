<x-app-layout>
    <head>
        <style>
            /* General Styling */
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f7fc;
                margin: 0;
                padding: 0;
            }

            /* Header Section */
            .header {
                text-align: center;
                padding: 50px 20px;
                background-color: #007bff;
                color: white;
                border-bottom: 5px solid #0056b3;
            }

            .header h1 {
                font-size: 2.5rem;
                margin-bottom: 15px;
            }

            .header p {
                font-size: 1.2rem;
                margin: 0;
                color: #d6e0f5;
            }

            /* Container Styling */
            .container {
                height: auto;
                padding: 30px;
                display: flex;
                justify-content: center;
                gap: 20px;
                flex-wrap: wrap;
                margin-top: 20px;
                background-color: #ffffff;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                width: 90%;
                max-width: 1200px;
                margin: 30px auto;
            }

            /* Button Styling */
            .btn {
                background-color: #007bff;
                color: #fff;
                padding: 15px 30px;
                font-size: 16px;
                font-weight: bold;
                text-decoration: none;
                text-align: center;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transition: background-color 0.3s ease, transform 0.2s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 300px;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            }

            .btn:hover {
                background-color: #0056b3;
                transform: translateY(-3px);
                box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
            }

            /* Button Icons */
            .btn i {
                margin-right: 8px;
                font-size: 18px;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .container {
                    flex-direction: column;
                    gap: 15px;
                }

                .btn {
                    width: 100%;
                }
            }

            /* Additional Information Section */
            .info-section {
                margin: 30px auto;
                text-align: center;
                color: #555;
                max-width: 800px;
            }

            .info-section h2 {
                font-size: 1.8rem;
                color: #333;
            }

            .info-section p {
                font-size: 1rem;
                line-height: 1.6;
                color: #666;
            }
        </style>
    </head>

    <!-- Header Section -->
    <div class="header">
        <h1>Welcome to HealthCare+</h1>
        <p>Manage your schedules and appointments with ease!</p>
    </div>

    <!-- Buttons Section -->
    <div class="container">
        <a href="{{ route('schedules.create') }}" class="btn">
            <i class="fas fa-calendar-plus"></i> Add Schedule
        </a>
        <a href="{{ route('appointments.doctor') }}" class="btn">
            <i class="fas fa-calendar-check"></i> View Appointments
        </a>
        <a href="{{ route('profile.edit') }}" class="btn">
            <i class="fas fa-user"></i> Edit Profile
        </a>
    </div>

    <!-- Additional Information Section -->
    <div class="info-section">
        <h2>How Can We Help You Today?</h2>
        <p>
            HealthCare+ offers a seamless experience for managing doctor schedules, viewing appointments, and accessing vital health-related services. 
            Use the options above to get started or explore our platform to discover more about how we simplify healthcare management for you.
        </p>
    </div>
</x-app-layout>
