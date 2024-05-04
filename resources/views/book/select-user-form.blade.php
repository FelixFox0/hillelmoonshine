@extends('layout.app')

@section('title', 'Book form')

@section('content')
    <div class="h-screen bg-white flex flex-col space-y-10 justify-center items-center">
        <div class="bg-white w-96 shadow-xl rounded p-5">
            <h1 class="text-3xl font-medium">Выберете пользователя</h1>
            @if (empty($users))
                <div class="margin: 20px" style="margin: 20px;">
                    <p class="text-red-500">Список пользователей пустой, нужно создать пользователей!</p>
                </div>
            @else
            <form action="{{ route("select_time_slot") }}" class="space-y-5 mt-5" method="POST">
                @csrf

                @if (session('message'))
                    <p class="text-green-500">
                        {{ session('message') }}
                    </p>
                @endif

                <select name="user_id" class="w-full h-12 border border-gray-800 rounded px-3 @error('user_id') border-red-500 @enderror">
                    <@foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>

                @error('user_id')
                <p class="text-red-500">{{ $message }}</p>
                @enderror

                <input name="step_hour" type="number" min="1" max="11" class="w-full h-12 border border-gray-800 rounded px-3 @error('step_hour') border-red-500 @enderror" placeholder="кол-во часов" />

                @error('step_hour')
                <p class="text-red-500">{{ $message }}</p>
                @enderror

                <input name="name" type="text" maxlength="250" class="w-full h-12 border border-gray-800 rounded px-3 @error('name') border-red-500 @enderror" placeholder="имя" />

                @error('name')
                <p class="text-red-500">{{ $message }}</p>
                @enderror


                <input name="phone" type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" class="w-full h-12 border border-gray-800 rounded px-3 @error('phone') border-red-500 @enderror" placeholder="Контактний телефон" />
                <label for="phone" style="margin-top: 10px">
                    <small>Введите номер телефона:<br />
                        Format: 123-456-7890</small>
                </label>

                @error('phone')
                <p class="text-red-500">{{ $message }}</p>
                @enderror

                <button type="submit" class="text-center w-full bg-blue-900 rounded-md text-white py-3 font-medium">Отправить</button>
            </form>
            @endif
        </div>
    </div>
@endsection
