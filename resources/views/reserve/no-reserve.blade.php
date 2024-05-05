@extends('layout.app')

@section('title', 'Немає доступних часових проміжків')

@section('content')
<div class="h-screen bg-white flex flex-col space-y-10 justify-center items-center">
    <div class="bg-white w-96 shadow-xl rounded p-5">
        <h1 class="text-3xl font-medium">Резерв не знайдено</h1>

        <p class="mt-5">На жаль, резерв з таким ідентифікатором не знайдено. Будь ласка, перевірте правильність введеного ідентифікатора та спробуйте ще раз.</p>

        <a href="{{ route('reservation.create.form') }}" class="text-center w-full bg-blue-900 rounded-md text-white py-3 font-medium mt-5 block">Повернутися до форми бронювання</a>
    </div>
</div>
@endsection
