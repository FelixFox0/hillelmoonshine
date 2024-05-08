<!DOCTYPE html>
<html>
<head>
    <title>Confirm Reservation</title>
</head>
<body>
    <form action="{{ route('confirm') }}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{ $request->user_id }}">
        <input type="hidden" name="name" value="{{ $request->name }}">
        <input type="hidden" name="phone" value="{{ $request->phone }}">
        <input type="hidden" name="hours" value="{{ $request->hours }}">
        <p>Available Hours:</p>
        <ul>
            @foreach ($availableHours as $hour)
            <input type="radio" name="reserved_at" value="{{ $hour }}"> {{ $hour }} <br>
            @endforeach
        </ul>
        <button type="submit">Confirm</button>
    </form>    
</body>
</html>
