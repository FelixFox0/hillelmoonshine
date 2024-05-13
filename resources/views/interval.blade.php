<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>HillelMoonshine</title>
</head>
<body>
<form action="success" method="post">
    @csrf

    <input type="hidden" name="user_id" value="{{ $userId }}">
    <input type="hidden" name="client_name" value="{{ $clientName }}">
    <input type="hidden" name="client_phone" value="{{ $clientPhone }}">

    <label>Оберіть інтервал:
        <select class="form-select" name="interval" required>
            @foreach($availableIntervals as $availableInterval)
                <option value="{{$availableInterval['start_time']}}:00-{{$availableInterval['end_time']}}:00">
                    {{$availableInterval['start_time']}}:00-{{$availableInterval['end_time']}}:00
                </option>
            @endforeach
        </select>
    </label>

    <button class="btn btn-primary" style="margin-bottom: 6px; padding: 6px 50px 6px 50px" type="submit">ОК</button>
</form>
</body>
</html>
