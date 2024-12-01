<<x-app-layout>
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

            h1 {
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
      </style>
    </head>

    <body>
        <!-- Sidebar -->
        <div class="sidebar">
            <h1>Healthcare+</h1>
            <br>
            <ul>
                <li><a><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="{{ route('admins.patient') }}"><i class="fas fa-user-injured"></i> Patients</a></li>
                <li><a href="{{ route('admins.doctor') }}"><i class="fas fa-user-md"></i> Doctors</a></li>
                <li><a href="{{ route('admins.appointment') }}"><i class="fas fa-calendar-check"></i> Appointments</a></li>
                <li><a href=""><i class="fas fa-calendar-day"></i> Schedules</a></li>
                <li><a href="{{route('admins.specialization')}}"><i class="fas fa-briefcase-medical"></i> Specialization</a></li>
             </ul>
        </div>

        <!--Create specialization-->
        <div class="container" style="max-width: 600px; margin: 0 auto; padding: 20px;">
            <div style="background-color: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <h1 style="font-size: 24px; font-weight: bold; text-align: center; color: #4A4A4A; margin-bottom: 20px;">Add New Specialization</h1>

                <form action="{{ route('specializations.store') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 20px;">
                        <label for="name" style="display: block; font-size: 16px; font-weight: 600; color: #555;">Specialization Name</label>
                        <input type="text" class="form-control" id="name" name="name" required
                            style="width: 100%; max-width: 400px; padding: 12px; margin-top: 8px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; outline: none;">
                    </div>

                    <button type="submit"
                        style="width: auto; padding: 12px 24px; background-color: #007BFF; color: white; font-weight: bold; border-radius: 5px; cursor: pointer; font-size: 16px; border: none;">
                        Add Specialization
                    </button>
                </form>
            </div>
        </div>

    </body>

    </html>
    </x-app-layout>