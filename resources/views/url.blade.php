@extends('layouts.app')

@section('content')
<main class="flex-grow-1">
    @include('flash::message')
    <div class="container-lg">

        <h1 class="mt-5 mb-3">Сайт: {{ $url->name}}</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tr>
                    <td>ID</td>
                    <td>{{ $url->id }}</td>
                </tr>
                <tr>
                    <td>Имя</td>
                    <td>{{ $url->name }}</td>
                </tr>
                <tr>
                    <td>Дата создания</td>
                    <td>{{ $url->created_at }}</td>
                </tr>
                <tr>
                    <td>Дата обновления</td>
                    <td>{{ $url->updated_at }}</td>
                </tr>
            </table>
        </div>
        <h2 class="mt-5 mb-3">Проверки</h2>
        <form method="post" action="{{ route('urls.checks.store', $url->id) }}">
            @csrf
            <input type="submit" class="btn btn-primary" value="Запустить проверку">
            <input name="urlid" type="hidden" value="{{ $url->id }}">
        </form>
        <table class="table table-bordered table-hover text-nowrap">
            <tr>
                <th>ID</th>
                <th>Код ответа</th>
                <th>h1</th>
                <th>keywords</th>
                <th>description</th>
                <th>Последняя проверка</th>
            </tr>
            @foreach ($checks as $check)
            <tr>
                <th>{{ $check->id }}</th>
                <th>{{ \Illuminate\Support\Str::limit($check->status_code, 3) }}</a></th>
                <th>{{ \Illuminate\Support\Str::limit($check->h1, 10) }}</th>
                <th>{{ \Illuminate\Support\Str::limit($check->keywords, 10) }}</th>
                <th>{{ \Illuminate\Support\Str::limit($check->description, 50) }}</th>
                <th>{{ $check->updated_at }}</th>
            </tr>
            @endforeach
        </table>
    </div>
</main>
@endsection