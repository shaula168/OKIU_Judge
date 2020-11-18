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
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/standings') }}">順位表</a></li>
                        @if ($is_teacher)
                            <li class="nav-item"><a class="nav-link active" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/status-lists') }}">提出状況一覧</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h3 class="mb-3">提出状況一覧</h3>
                    <p class="text-danger">正解していない学生は表示されません。</p>
                    <table class="table table-bordered text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>名前</th>
                                <th>学籍番号</th>
                                <th>合格</th>
                                <th>提出期限後に正解</th>
                            </tr>
                        </thead>
                        @foreach ($status_lists as $status)
                            <tr>
                                <td><a href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/submissions') . '?member_id=' . $status->id }}">{{ $status->name }}</a></td>
                                <td>{{ $status->student_number }}</td>
                                @if ($status->is_pass)
                                    <td>〇</td>
                                    <td> </td>
                                @else
                                    <td> </td>
                                    <td>〇</td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection