<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            h1{
                font-size: 30px;
                font-weight: bold;
            }

            /* Sidebar Styling */
            .sidebar {
                width: 250px;
                background-color: #343a40;
                color: #fff;
                height: 100%;
                position: fixed;
                left: 0;
                top: 0;
                padding: 20px;
            }

            .sidebar h2 {
                color: #fff;
                text-align: center;
                margin-bottom: 20px;
            }

            .sidebar ul {
                list-style: none;
                padding: 0;
            }

            .sidebar ul li {
                margin-bottom: 20px;
            }

            .sidebar ul li a {
                color: #adb5bd;
                text-decoration: none;
                font-size: 1rem;
                display: flex;
                align-items: center;
                padding: 10px;
                border-radius: 5px;
                transition: background-color 0.3s;
            }

            .sidebar ul li a:hover {
                background-color: #495057;
                color: #fff;
            }

            .sidebar ul li a i {
                margin-right: 10px;
            }

            /* Main Content Styling */
            .main-content {
                margin-left: 250px;
                padding: 20px;
                width: calc(100% - 250px);
            }

            .dashboard-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }

            .dashboard-header h1 {
                font-size: 1.5rem;
                color: #333;
            }

            .cards-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
            }

            .card {
                background-color: #fff;
                border-radius: 10px;
                padding: 20px;
                text-align: center;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease;
            }

            .card:hover {
                transform: translateY(-10px);
            }

            /* Add different background colors */
            .card-patients {
                background-color: #e0f2b3; /* Light red */
            }

            .card-doctors {
                background-color: #d1ecf1; /* Light blue */
            }

            .card-appointments {
                background-color: #d4edda; /* Light green */
            }

            .card-specializations {
                background-color: #b3bef2; /* Light yellow */
            }

            .card-schedules {
                background-color: #e2e3e5; /* Light gray */
            }

            .card i {
                font-size: 2rem;
                margin-bottom: 10px;
                display: block;
                color: #007bff;
            }

            .card h3 {
                font-size: 1.2rem;
                color: #333;
                margin-bottom: 10px;
            }

            .card p {
                font-size: 1rem;
                color: #555;
            }

            .card span {
                font-size: 2rem;
                font-weight: bold;
                color: #4CAF50;
            }
        </style>
    </head>

    <body>
        <!-- Sidebar -->
        <div class="sidebar">
            <h1>Healthcare+</h1>
            <br>
            <ul>
                <li><a href="{{route('admins.index')}}"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="{{ route('admins.patient') }}"><i class="fas fa-user-injured"></i> Patients</a></li>
                <li><a href="{{ route('admins.doctor') }}"><i class="fas fa-user-md"></i> Doctors</a></li>
                <li><a href="{{ route('admins.appointment') }}"><i class="fas fa-calendar-check"></i> Appointments</a></li>
                <li><a href=""><i class="fas fa-calendar-day"></i> Schedules</a></li>
                <li><a href="{{route('admins.specialization')}}"><i class="fas fa-briefcase-medical"></i> Specialization</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="dashboard-header">
                <h4 style="font-size:25px">Admin Dashboard</h4>
            </div>
            <div class="cards-container">
                <div class="card card-patients">
                    <i class="fas fa-user-injured"></i>
                    <a href="{{ route('admins.patient') }}">Patients</a>
                    <p>Total: <span>150</span></p>
                </div>

                <div class="card card-doctors">
                    <i class="fas fa-user-md"></i>
                    <a href="{{ route('admins.doctor') }}">Doctors</a>
                    <p>Total: <span>53</span></p>
                </div>

                <div class="card card-appointments">
                    <i class="fas fa-calendar-check"></i>
                    <a href="{{ route('admins.appointment') }}">Appointments</a>
                    <p>Total: <span>44</span></p>
                </div>

                <div class="card card-specializations">
                    <i class="fas fa-briefcase-medical"></i>
                    <a href="{{ route('admins.specialization') }}">Specialization</a>   
                    <p>Total: <span>44</span></p>
                </div>

                <div class="card card-schedules">
                    <i class="fas fa-calendar-day"></i>
                    <h3>Schedules</h3>
                    <p>Total: <span>65</span></p>
                </div>
            </div>
        </div>
    </body>

    </html>
</x-app-layout>
