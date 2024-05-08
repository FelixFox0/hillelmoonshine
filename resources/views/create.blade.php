<!DOCTYPE html>
<html>
<head>
    <title>Create Reservation</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <form id="reservation-form" action="{{ route('store') }}" method="post">
        @csrf
        <select name="user_id" id="user_id">
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        <input type="text" name="name" id="name" placeholder="Name">
        <input type="text" name="phone" id="phone" placeholder="Phone">
        <input type="number" name="hours" id="hours" placeholder="Number of Hours">
        <button type="submit" id="submit-btn">Submit</button>
    </form>
</body>
</html>
