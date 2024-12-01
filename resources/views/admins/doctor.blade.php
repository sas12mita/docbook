<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>List of Patients</title>
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
                color: #fff;
            }

            /* Sidebar Styling */
            .sidebar {
                width: 250px;
                background-color: #212529;
                /* Dark Sidebar */
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
                padding-left: 20px;
                width: calc(100% - 250px);
                background-color: #fff;
                /* White Background for Main Content */
                color: #000;
                /* Black Text for Main Content */
                min-height: 100vh;
            }

            .container {
                max-width: 900px;
                margin: 20px auto;
                padding: 20px;
                background-color: #fff;
                /* White Background for Container */
                border: 1px solid #ddd;
                border-radius: 8px;
                color: #000;
                /* Black Text Color */
            }

            /* Table Styling */
            .table {
                width: 100%;
                border-collapse: collapse;
                background-color: #fff;
                /* White Background for Table */
                color: #000;
                /* Black Text in Table */
            }

            .table th,
            .table td {
                padding: 10px;
                text-align: left;
                border: 1px solid #ddd;
            }

            .table th {
                background-color: #007bff;
                color: #fff;
            }

            .table td {
                background-color: #f8f9fa;
                /* Light Background for Table Cells */
            }

            .empty-message {
                text-align: center;
                color: #666;
            }

            /* Card and Table Button Styling */
            .card,
            .table td button {
                color: #fff;
                border: none;
                padding: 10px;
                border-radius: 5px;
                cursor: pointer;
            }

            .table td button {
                background-color: #f94144;
                /* Red for Delete */
            }

            .table td button:hover {
                background-color: #e31b2f;
                /* Darker Red on Hover */
            }
        </style>
    </head>

    <body>
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Healthcare+</h2>
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
            <div class="container">
                <h2 class="text-center">List of Doctors</h2>

                @if($doctors->isEmpty())
                <p class="empty-message">No patients found.</p>
                @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($doctors as $doctor)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $doctor->user->name }}</td>
                            <td>{{ $doctor->user->email }}</td>
                            <td>{{ $doctor->user->address ?? 'N/A' }}</td>
                            <td class="flex space-x-2">
                                <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this patient?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color:cadetblue;padding:10px;color:white">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </body>

    </html>
</x-app-layout>