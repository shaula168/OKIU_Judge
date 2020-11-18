@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="mt-2 mb-3 d-flex">
                    <div class="h2 mt-auto mb-auto">{{ $task->title }}</div>
                </div>
                <div class="mb-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id) }}">トップ</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/issues') }}">質問</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/submissions') }}">提出一覧</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/answer') }}">模範解答</a></li>
                        <li class="nav-item"><a class="nav-link active" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/standings') }}">順位表</a></li>
                        @if ($is_teacher)
                            <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/status-lists') }}">提出状況一覧</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h3 class="mb-3">順位表</h3>
                    <h5>最速正解者トップ３</h5>
                    <table class="table table-bordered text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>順位</th>
                                <th>名前</th>
                                <th>学籍番号</th>
                                <th>提出日</th>
                            </tr>
                        </thead>
                        @foreach ($standings as $standing)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $standing->name }}</td>
                                <td>{{ $standing->student_number }}</td>
                                <td>{{ $standing->created_at }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <h5 class="mt-5">あなたの順位：{{ $my_standing }}</h5>
                </div>
            </div>
        </div>
    </div>
@endsection