<x-layout>
    <h2>Create Appointment</h2>

    <form method="POST" action="{{ route("appointments.store") }}">
        @csrf

        <p>
            <label for="timestamp">Date and time</label>
            <input
                id="timestamp"
                name="timestamp"
                type="datetime-local"
                class="@error('timestamp') is-invalid @enderror"
                value="{{ old('timestamp') }}"
            />
        @error('timestamp')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </p>

        <p>
            <label for="names">Full name</label>
            <input
                id="names"
                name="names"
                type="text"
                class="@error('names') is-invalid @enderror"
                value="{{ old('names') }}"
            />
        @error('names')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </p>

        <p>
            <label for="ucn">UCN (ЕГН)</label>
            <input
                id="ucn"
                name="ucn"
                type="text"
                class="@error('ucn') is-invalid @enderror"
                value="{{ old('ucn') }}"
            />
        @error('ucn')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </p>

        <div>
            <label for="description">Description</label>
            <textarea
                id="description"
                name="description"
                class="@error('description') is-invalid @enderror"
            >{{ old('description') }}</textarea>
            @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <p>
            <label for="notification_type_id">Notification type</label>
            <select
                id="notification_type_id"
                name="notification_type_id"
                class="@error('notification_type_id') is-invalid @enderror"
            >
                @foreach($notificationTypes as $nt)
                    <option value="{{$nt->id}}"
                            {{old('notification_type_id') == $nt->id ? 'selected' : ''}}
                    >{{$nt->name}}</option>
                @endforeach
            </select>
        @error('notification_type_id')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </p>

        <p>
            <button type="submit">Submit</button>
        </p>

    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</x-layout>
