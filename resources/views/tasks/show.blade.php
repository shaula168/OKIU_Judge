@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-danger">
            {{ session('status') }}
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="mt-2 mb-3 d-flex">
                    <div class="h2 mt-auto mb-auto">{{ $task->title }}</div>
                    @if ($is_teacher)
                        <a href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/edit') }}" class="ml-3 btn btn-outline-secondary">
                            問題を編集する
                        </a>
                    @endif
                </div>
                <div class="mb-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id) }}">トップ</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/issues') }}">質問</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/submissions') }}">提出一覧</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/answer') }}">模範解答</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/standings') }}">順位表</a></li>
                        @if ($is_teacher)
                            <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/status-lists') }}">提出状況一覧</a></li>
                        @endif
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-5" style="height: 250px">
                            <div class="card-header h4">問題文</div>
                            <div class="card-body overflow-auto" style="font-size: large">
                                {!! nl2br(e($task->statement)) !!}
                            </div>
                        </div>
                        @if (isset($task->hint))
                            <div class="card mb-5" style="height: 250px">
                                <div class="card-header h4">ヒント</div>
                                <div class="card-body overflow-auto" style="font-size: large">
                                    {!! nl2br(e($task->hint)) !!}
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div id="editor" style="height: 500px"></div>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js" integrity="sha512-GZ1RIgZaSc8rnco/8CXfRdCpDxRCphenIiZ2ztLy3XQfCbQUSCuk8IudvNHxkRA3oUg6q0qejgN/qqyG1duv5Q==" crossorigin="anonymous"></script>
                        <script>
                            var editor = ace.edit("editor");
                            editor.setTheme("ace/theme/monokai");
                            editor.setFontSize(14);
                            editor.getSession().setMode("ace/mode/java");
                            editor.getSession().setUseWrapMode(true);
                            editor.getSession().setTabSize(2);
                        </script>
                        @if ($is_teacher)
                            <script>
                                function check() {
                                    if(window.confirm('模範解答として登録しますか？\n' +
                                        '※既に模範解答が登録されている場合は上書きされます。\n' +
                                        '※ジャッジの成否に関係なく登録される為、ジャッジが通らなかった場合は' +
                                        'テストケースを見直すか、コードを修正して再提出をお願いします。)')) {
                                        document.getElementById("code").value = editor.getValue();
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
                            </script>
                        @else
                            <script>
                                function check() {
                                    if(window.confirm('提出しますか？')) {
                                        document.getElementById("code").value = editor.getValue();
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
                            </script>
                        @endif
                        <noscript>JavaScriptを有効にしてください。</noscript>
                        <form method="post" action="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/submit') }}"  onSubmit="return check()">
                            {{ csrf_field() }}
                            <input name="code" id="code" type="hidden">

                            <div class="float-left mt-3">
                                <p class="text-secondary">※クラス名は「Main」にする必要があります。</p>
                            </div>

                            <div class="float-right mt-3">
                                <button type="submit" class="btn btn-primary">提出する</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection