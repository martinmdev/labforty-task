<x-layout>
    <h2>Appointments</h2>

    <p><a href="{{ route("appointments.create") }}">Create appointment</a></p>
    <div class="container">
        @if(count($appointments))
            <form>

                <label for="date_from">From</label>
                <input
                    id="date_from"
                    name="date_from"
                    type="datetime-local"
                    value="{{$dateFrom}}"
                />

                <label for="date_to">To</label>
                <input
                    id="date_to"
                    name="date_to"
                    type="datetime-local"
                    value="{{$dateTo}}"
                />

                <label for="ucn">Ucn</label>
                <input
                    id="ucn"
                    name="ucn"
                    type="text"
                    value="{{$ucn}}"
                />

                <button type="submit">Search</button>
            </form>
            @include('appointments.table', ['appointments' => $appointments])
        @endif
    </div>

    <div>
        {{ $appointments->links() }}
    </div>

</x-layout>
