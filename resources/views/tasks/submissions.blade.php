@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('submissions_task', $classroom, $task) }}
@endsection

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
                        <li class="nav-item"><a class="nav-link active" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/submissions') }}">提出一覧</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/answer') }}">模範解答</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/standings') }}">順位表</a></li>
                        @if ($is_teacher)
                            <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/status-lists') }}">提出状況一覧</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h3 class="mb-3">提出一覧</h3>
                    <table class="table table-bordered text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>名前</th>
                                <th>学籍番号</th>
                                <th>結果</th>
                                <th>提出日</th>
                                <th> </th>
                            </tr>
                        </thead>
                        @foreach($submissions as $submit)
                            <tr>
                                <td><a href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/submissions') . '?member_id=' . $submit->member_id }}">{{ $submit->name }}</a></td>
                                <td>{{ $submit->student_number }}</td>
                                @if($submit->result == 1)
                                    <td>正解</td>
                                @elseif($submit->result == -1)
                                    <td>不正解</td>
                                @else
                                    <td>判定中</td>
                                @endif
                                <td>{{ date($submit->created_at) }}</td>
                                <td><a href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/submission/' . $submit->id) }}">詳細</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="mx-auto">{{ $submissions->links() }}</div>
            </div>
        </div>
    </div>
@endsection