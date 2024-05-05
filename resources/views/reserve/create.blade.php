@extends('layout.app')

@section('title', 'Бронювання часу')

@section('content')
    <div class="h-screen bg-white flex flex-col space-y-10 justify-center items-center">
        <div class="bg-white w-96 shadow-xl rounded p-5">
            <h1 class="text-3xl font-medium">Бронювання часу</h1>

            <form action="{{ route('reservation.store') }}" class="space-y-5 mt-5" method="POST">
                @csrf

                <select name="user_id" class="w-full h-12 border border-gray-800 rounded px-3">
                    @foreach ($users as $user)
                        <option value="{{ $user->getId() }}">{{ $user->getId() }} - {{ $user->getName() }}</option>
                    @endforeach
                </select>

                <input name="hours" type="text" class="w-full h-12 border border-gray-800 rounded px-3" placeholder="Кількість годин" required />

                <input name="name" type="text" class="w-full h-12 border border-gray-800 rounded px-3" placeholder="Ім'я" required />

                <input name="phone" type="text" class="w-full h-12 border border-gray-800 rounded px-3" placeholder="Контактний телефон" required />

                <button type="submit" class="text-center w-full bg-blue-900 rounded-md text-white py-3 font-medium">Забронювати</button>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li style="color: red;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection
