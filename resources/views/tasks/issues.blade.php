@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('issue_task', $classroom, $task) }}
@endsection

@section('message')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
                        <li class="nav-item"><a class="nav-link active" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/issues') }}">質問</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/submissions') }}">提出一覧</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/answer') }}">模範解答</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/standings') }}">順位表</a></li>
                        @if ($member->is_teacher)
                            <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/status-lists') }}">提出状況一覧</a></li>
                        @endif
                    </ul>
                </div>
                <div class="card row">
                    <div class="col-lg-10 mx-auto">
                        <div class="card mt-3 mb-5 ml-3">
                            <div class="card-body">
                                <h5 class="card-title">投稿フォーム</h5>
                                <form method="post" action="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/post-issue') }}">
                                    {{ csrf_field() }}
                                    <textarea name="new_statement" id="new_statement" rows="3" class="textarea w-100"></textarea>
                                    <div class="float-right mt-3">
                                        <button type="submit" class="btn btn-primary">投稿する</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @foreach($issues as $issue)
                            <div class="card mb-3 ml-3">
                                <div class="card-body">
                                    <div class="card-title" style="font-size: large">
                                        <span>{{ $issue->name }}</span>
                                        @if (!empty($issue->student_number))
                                            <span> ({{ $issue->student_number }}) </span>
                                        @endif
                                        @if ($issue->is_teacher)
                                            <span class="badge badge-secondary">教師ユーザー</span>
                                        @endif
                                    </div>
                                    {{!! nl2br(e($issue->statement)) !!}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mx-auto">{{ $issues->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection