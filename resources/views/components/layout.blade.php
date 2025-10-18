<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Lab40 Task' }}</title>
</head>
<body>
<h1>Lab40 Task</h1>
<a href="/">Home</a>
<a href="{{ route("appointments.index") }}">Appointments</a>
<a href="{{ route("appointments.create") }}">Create appointment</a>
<hr/>
@include('components.messages')
{{ $slot }}
</body>
</html>
