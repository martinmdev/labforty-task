<x-layout>
    <h2>Appointment {{ $appointment->id }}</h2>

    <table>
        <tr>
            <td>Id</td>
            <td>{{ $appointment->id }}</td>
        </tr>
        <tr>
            <td>Date and time</td>
            <td>{{ $appointment->timestamp }}</td>
        </tr>
        <tr>
            <td>Full name</td>
            <td>{{ $appointment->names }}</td>
        </tr>
        <tr>
            <td>UCN</td>
            <td>{{ $appointment->ucn }}</td>
        </tr>
        <tr>
            <td>Description</td>
            <td>{{ $appointment->description }}</td>
        </tr>
        <tr>
            <td>Notification type</td>
            <td>{{ $appointment->notificationType->name }}</td>
        </tr>
    </table>

    <a href="{{ route("appointments.edit", ['appointment' => $appointment->id]) }}">Edit</a>

    <form method="POST" action="{{ route("appointments.destroy", ['appointment' => $appointment->id]) }}"
          onsubmit="return confirm('Do you really want to delete the appointment?');"
    >
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>

    <div>
        @include('appointments.table', ['appointments' => $upcomingAppointments])
    </div>

</x-layout>
