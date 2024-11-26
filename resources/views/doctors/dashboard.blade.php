<x-app-layout>
    <head>
        <style>
            .container{
                height: auto;
                padding:30px;
                display: flex;
                justify-content: center;
                gap:10px;
            }
            .btn{
                background-color: cornflowerblue;
                padding: 20px;
            }
        </style>
    </head>
    <br>
    <div class="container">
    <a href="{{ route('schedules.create') }}" class="btn">Add Schedule</a>
    <a href="{{ route('appointments.doctor') }}" class="btn">View Appointments</a>
    </div>

</x-app-layout>