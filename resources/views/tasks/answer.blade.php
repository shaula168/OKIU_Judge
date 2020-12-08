@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('answer_task', $classroom, $task) }}
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
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/submissions') }}">提出一覧</a></li>
                        <li class="nav-item"><a class="nav-link active" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/answer') }}">模範解答</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/standings') }}">順位表</a></li>
                        @if ($is_teacher)
                            <li class="nav-item"><a class="nav-link" href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/status-lists') }}">提出状況一覧</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h3 class="mb-3">模範解答</h3>
                    <div id="editor" style="height: 500px" class="mb-5"></div>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js" integrity="sha512-GZ1RIgZaSc8rnco/8CXfRdCpDxRCphenIiZ2ztLy3XQfCbQUSCuk8IudvNHxkRA3oUg6q0qejgN/qqyG1duv5Q==" crossorigin="anonymous"></script>
                    <script>
                        var editor = ace.edit("editor");
                        editor.setTheme("ace/theme/monokai");
                        editor.setFontSize(14);
                        editor.getSession().setMode("ace/mode/java");
                        editor.getSession().setUseWrapMode(true);
                        editor.getSession().setTabSize(2);
                        editor.setValue('{{ $submission->code_txt }}');
                        editor.setReadOnly(true);
                    </script>
                    <noscript>JavaScriptを有効にしてください。</noscript>

                    @if (!empty($submission->cmpinfo))
                        <div class="form-group mb-3">
                            <label for="cmpinfo" class="h5">コンパイルエラー出力：</label>
                            <textarea id="cmpinfo" class="form-control" readonly="readonly" rows="5">{{ $submission->cmpinfo }}</textarea>
                        </div>
                    @endif
                    @if (!empty($submission->stderr))
                        <div class="form-group mb-3">
                            <label for="stderr" class="h5">標準エラー出力：</label>
                            <textarea id="stderr" class="form-control" readonly="readonly" rows="5">{{ $submission->stderr }}</textarea>
                        </div>
                    @endif
                    <div class="form-group mb-3">
                        <label for="stderr" class="h5">出力結果：</label>
                        <textarea id="stderr" class="form-control" readonly="readonly" rows="5">{{ $submission->stdout }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection