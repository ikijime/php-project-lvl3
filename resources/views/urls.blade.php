@extends('layouts.app')

@section('content')
<main class="flex-grow-1">
    @include('flash::message')
    <div class="container-lg">
    <h1 class="mt-5 mb-3">Сайты</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Последняя проверка</th>
                <th>Код ответа</th>
            </tr>

            @foreach ($urls as $url)
            <tr>
                <th>{{ $url->id }}</th>
                <th><a href="/urls/{{$url->id}}">{{ $url->name }}</a></th>
                <th>{{ $url->updated_at ?? null }}</th>
                <th>{{ $checks[$url->id]->status_code ?? null }}</th>
            </tr>
            @endforeach
            </table>
            {{ $urls->links() }}
        </div>
    </div>
</main>
@endsection