@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card mb-5">
                <div class="card-header d-flex">
                    <div class="h5 my-auto">あなたが管理するクラス一覧</div>
                    <div class="ml-3 my-auto">
                        <a href="{{ url('classrooms/create') }}">
                            <button class="btn btn-primary btn-sm">新しいクラスを作成する</button>
                        </a>
                    </div>
                </div>
                @foreach ($manage_classrooms as $classroom)
                    <div class="card-body">
                        <a href="{{ url('classrooms/' . $classroom->id) }}" class="text-secondary">
                            {{ $classroom->title }}
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="card">
                <div class="card-header d-flex">
                    <div class="h5 my-auto">あなたが参加するクラス一覧</div>
                    <div class="ml-3 my-auto">
                        <a href="{{ url('classrooms/join') }}">
                            <button class="btn btn-primary btn-sm">クラスに参加する</button>
                        </a>
                    </div>
                </div>
                @foreach ($participate_classrooms as $classroom)
                    <div class="card-body">
                        <a href="{{ url('classrooms/' . $classroom->id) }}" class="text-secondary">
                            {{ $classroom->title }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
