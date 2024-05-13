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
    <form action="interval" method="post">
        @csrf

        <label class="form-label">ID робітника:
            <input class="form-control" type="text" name="user_id" required>
        </label>
        <label class="form-label">Кількість годин:
            <input class="form-control" type="text" name="reserve_period" required>
        </label>
        <label class="form-label">Ім'я замовника:
            <input class="form-control" type="text" name="client_name" required>
        </label>
        <label class="form-label">Телефон замовника:
            <input class="form-control" type="text" name="client_phone" required>
        </label>

        <button class="btn btn-primary" style="margin-bottom: 6px; padding: 6px 50px 6px 50px" type="submit">ОК</button>
    </form>
</body>
</html>
