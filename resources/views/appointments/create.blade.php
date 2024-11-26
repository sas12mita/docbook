<x-app-layout>
<div class="container mt-5">
    <h2 class="text-center">Book an Appointment</h2>
    <form action="{{ route('appointments.store') }}" method="POST" class="p-4 shadow-sm rounded" style="background-color: #f9f9f9;">
        @csrf

        <!-- Appointment Date -->
        <div class="mb-3">
            <label for="appointment_date" class="form-label"><strong>Appointment Date:</strong></label>
            <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
        </div>

        <!-- Start Time -->
        <div class="mb-3">
            <label for="start_time" class="form-label"><strong>Start Time:</strong></label>
            <input type="time" class="form-control" id="start_time" name="start_time" required>
        </div>

        <!-- End Time -->
        <div class="mb-3">
            <label for="end_time" class="form-label"><strong>End Time:</strong></label>
            <input type="time" class="form-control" id="end_time" name="end_time" required>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">Book Appointment</button>
        </div>
    </form>
</div>

</x-app-layout>