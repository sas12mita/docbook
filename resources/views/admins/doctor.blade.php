<x-app-layout>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Patients</title>
    <style>
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #007bff;
            color: #fff;
        }

        .empty-message {
            text-align: center;
            color: #666;
        }
    </style>

    <div class="container">
        <h2 class="text-center">List of doctors</h2>

        @if($doctors->isEmpty())
            <p class="empty-message">No doctor found.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->user->name }}</td>
                            <td>{{ $doctor->user->email }}</td>
                            <td>{{ $doctor->user->address ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
