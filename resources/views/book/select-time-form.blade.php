@extends('layout.app')

@section('title', 'Book form')

@section('content')
    <div class="h-screen bg-white flex flex-col space-y-10 justify-center items-center">
        <div class="bg-white w-96 shadow-xl rounded p-5">
            <h1 class="text-3xl font-medium">Выберете время</h1>

            <form action="{{ route("process_book_form") }}" class="space-y-5 mt-5" method="POST">
                @csrf

                <select name="time_slot" class="w-full h-12 border border-gray-800 rounded px-3 ">
                    <@foreach($reserveDto->getSlots() as $slot)
                        <option value="{{ json_encode($slot) }}">{{ date('H-i', strtotime($slot['start'])) }}
                            - {{ date('H-i', strtotime($slot['end'])) }}</option>
                    @endforeach
                </select>

                <input name="user_id" value="{{ $reserveDto->getUserId()  }}" type="hidden"
                       class="w-full h-12 border border-gray-800 rounded px-3" placeholder="user id"/>

                <input name="name" value="{{ $reserveDto->getName() }}" type="hidden"
                       class="w-full h-12 border border-gray-800 rounded px-3" placeholder="ім`я"/>

                <input name="phone" value="{{ $reserveDto->getPhone() }}" type="hidden"
                       class="w-full h-12 border border-gray-800 rounded px-3" placeholder="Контактний телефон"/>

                <button type="submit" class="text-center w-full bg-blue-900 rounded-md text-white py-3 font-medium">
                    Отправить
                </button>
            </form>
        </div>
    </div>
@endsection