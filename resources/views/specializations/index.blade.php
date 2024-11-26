<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Type of Specialization</title>
    <style>
        /* General styling for the form */
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
<body>
<form action="{{ route('doctors.index') }}" method="POST" class="patient-form">
    @csrf
    <div class="form-group">
        <label for="specialization">Choose a specialization:</label>
        <select name="specialization_id" id="specialization" class="form-control" required>
            @foreach($specializations as $specialization)
                <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="submit-btn">Submit</button>
    </div>
</form>


</body>
</html>
