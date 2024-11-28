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
                background-color: #1e3a8a; /* Dark blue header */
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
                max-width: 900px;
                margin: 40px auto;
                padding: 30px;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            }
            h2 {
                color: #1e3a8a; /* Blue color */
                font-size: 28px;
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
                margin-top: 40px;
            }
            
            /* Button Styling */
            .btn {
                background-color: #1e3a8a; /* Blue button */
                color: #fff;
                padding: 20px 40px;
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
                background-color: #1e40af; /* Slightly lighter blue on hover */
                transform: translateY(-6px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            }

            .btn i {
                font-size: 20px;
            }

            /* Recent Activity Section */
            .recent-activity {
                background-color: #f0f7ff; /* Light blue background */
                padding: 20px;
                margin-top: 40px;
                border-radius: 8px;
                box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            }

            .recent-activity h3 {
                font-size: 22px;
                color: #1e3a8a; /* Blue heading */
                margin-bottom: 15px;
            }

            .activity-item {
                display: flex;
                justify-content: space-between;
                padding: 12px;
                background-color: #ffffff;
                border-radius: 6px;
                margin-bottom: 10px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .activity-item .icon {
                font-size: 20px;
                color: #1e3a8a; /* Blue icon */
            }

            .activity-item .content {
                flex-grow: 1;
                margin-left: 10px;
                color: #333;
            }

            .activity-item .timestamp {
                font-size: 14px;
                color: #888;
                align-self: center;
            }

            /* Notification Section */
            .notifications {
                background-color: #cce4ff; /* Light blue notification background */
                padding: 15px;
                border-radius: 8px;
                margin-top: 30px;
                box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            }

            .notifications h4 {
                margin: 0;
                font-size: 18px;
                color: #1e3a8a; /* Blue heading */
            }

            .notification-item {
                background-color: #fff;
                padding: 10px;
                margin-top: 10px;
                border-radius: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>
    <div class="container">
        <h2>Welcome to Your Dashboard</h2>
        <p>Manage your appointments and view schedules with ease. Navigate through the options below.</p>

        <div class="button-container">
            <a href="{{ route('specializations.patient') }}" class="btn">
                <i class="fas fa-calendar-alt"></i> View Schedule
            </a>
            <a href="{{ route('appointments.patient') }}" class="btn">
                <i class="fas fa-notes-medical"></i> View Appointments
            </a>
        </div>

        <!-- Recent Activity Section -->
        <div class="recent-activity">
            <h3>Recent Activity</h3>
            <div class="activity-item">
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="content">Your visit to the doctor has been confirmed for tomorrow.</div>
                <div class="timestamp">Just Now</div>
            </div>
            <div class="activity-item">
                <div class="icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="content">You have a new consultation scheduled with a doctor.</div>
                <div class="timestamp">2 hours ago</div>
            </div>
        </div>

        <!-- Notifications Section -->
        <div class="notifications">
            <h4>Important Notifications</h4>
            <div class="notification-item">
                Your appointment has been rescheduled to 3 PM tomorrow.
            </div>
            <div class="notification-item">
                Don’t forget to complete your health survey before your next visit.
            </div>
        </div>
    </div>
</x-app-layout>
