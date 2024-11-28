<x-app-layout>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Patients</title>
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
        <h2 class="text-center">List of Patients</h2>

        @if($patients->isEmpty())
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
                    @foreach($patients as $patient)
                        <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $patient->user->name }}</td>
                            <td>{{ $patient->user->email }}</td>
                            <td>{{ $patient->user->address ?? 'N/A' }}</td>
                            <td class="flex space-x-2">
                                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this patient?')">
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
</x-app-layout>
