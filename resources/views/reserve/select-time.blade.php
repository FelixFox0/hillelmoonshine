@extends('layout.app')
@section('title', 'Вибір часу бронювання')
@section('content')
    <div class="h-screen bg-white flex flex-col space-y-10 justify-center items-center">
        <div class="bg-white w-96 shadow-xl rounded p-5">
            <h1 class="text-3xl font-medium">Вибір часу бронювання</h1>

            <form action="{{ route('reservation.confirmation.submit', ['reserveId' => $reserveId]) }}" class="space-y-5 mt-5" method="POST">
                @csrf
                <input type="hidden" name="reserveId" value="{{ $reserveId }}">
                <p>Оберіть час для бронювання:</p>
                <select name="time" class="w-full h-12 border border-gray-800 rounded px-3">
                    @if (count($availableTimes) > 0)
                        @foreach ($availableTimes as $availableTime)
                            <option value="{{ $availableTime }}">{{ $availableTime }}</option>
                        @endforeach
                    @else
                        <option value="">Немає доступних слотів</option>
                    @endif
                </select>
                <button type="submit" class="text-center w-full bg-blue-900 rounded-md text-white py-3 font-medium">Підтвердити</button>
            </form>

        </div>
    </div>
@endsection

