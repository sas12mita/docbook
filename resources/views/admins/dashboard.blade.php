<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            padding: 20px;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card-content h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 10px;
        }

        .card-content p {
            font-size: 1rem;
            color: #777;
        }

        .total-number {
            font-weight: bold;
            font-size: 1.2rem;
            color: #4CAF50;
        }
    </style>

    <body>
        <div class="dashboard-container">
            <div class="card">
                <div class="card-content">
                    <a href="{{ route('admins.patient') }}">
                        <h3>Patients</h3>
                    </a>
                    <p>Total: <span class="total-number">120</span></p>
                </div>
            </div>

            <div class="card">
                <div class="card-content">

                    <a href="{{ route('admins.doctor') }}">
                        <h3>Doctors</h3>
                    </a>
                    <p>Total: <span class="total-number">45</span></p>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <h3>Appointments</h3>
                    <p>Total: <span class="total-number">200</span></p>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <h3>Schedules</h3>
                    <p>Total: <span class="total-number">30</span></p>
                </div>
            </div>
        </div>
    </body>

    </html>

</x-app-layout>