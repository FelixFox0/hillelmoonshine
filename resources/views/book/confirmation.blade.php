@extends('layout.app')

@section('title', 'Confirmation')

@section('content')
    <div class="h-screen bg-white flex flex-col space-y-10 justify-center items-center">
        <div class="bg-white w-96 shadow-xl rounded p-5">
            <h1 class="text-3xl font-medium">Поздравляю! Вы успешно записаны</h1><br>
            <p>Детали записи:</p><br>
            <p>Id записи: {{$reserveDto->getReserveId()}}</p><br>
            <p>Имя: {{$reserveDto->getName()}}</p><br>
            <p>Телефон: {{$reserveDto->getPhone()}}</p><br>
            <p>Дата: {{ date('Y-m-d', strtotime($reserveDto->getSlots()['start'])) }}</p><br>
            <p>Время: с {{ date('H-i', strtotime($reserveDto->getSlots()['start'])) }}
                по {{ date('H-i', strtotime($reserveDto->getSlots()['end'])) }}
            </p><br>
            <form action="{{ route("select_user_from") }}" class="space-y-5 mt-5" method="GET">
                @csrf
                <button type="submit" class="text-center w-full bg-blue-900 rounded-md text-white py-3 font-medium">
                   Записаться еще
                </button>
            </form>
        </div>
    </div>
@endsection
