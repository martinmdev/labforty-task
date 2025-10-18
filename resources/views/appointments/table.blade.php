@if(count($appointments))
    <table>
        <tr>
            <td>Id</td>
            <td>Date and time</td>
            <td>Full name</td>
            <td>Ucn</td>
            <td>Description</td>
            <td>Notification type</td>
            <td></td>
            <td></td>
        </tr>
        @foreach ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->id }}</td>
                <td>{{ $appointment->timestamp }}</td>
                <td>{{ $appointment->names }}</td>
                <td>{{ $appointment->ucn }}</td>
                <td>{{ $appointment->description }}</td>
                <td>{{ $appointment->notification_type }}</td>
                <td>
                    <a href="{{ route("appointments.show", ['appointment' => $appointment->id]) }}">Show</a>
                    <a href="{{ route("appointments.edit", ['appointment' => $appointment->id]) }}">Edit</a>
                </td>
                <td>
                    <form method="POST"
                          action="{{ route("appointments.destroy", ['appointment' => $appointment->id]) }}"
                          onsubmit="return confirm('Do you really want to delete the appointment?');"
                    >
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endif
