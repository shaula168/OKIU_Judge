@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="mt-2 mb-3 d-flex">
                    <div class="h2 mt-auto mb-auto">{{ $classroom->title }}</div>
                    @if ($is_teacher)
                        <div class="ml-3 mt-auto mb-auto">
                            <a href="{{ url('classrooms/' . $classroom->id . '/edit') }}">
                                <button class="btn btn-secondary btn-sm">クラスの詳細を編集する</button>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card mb-5">
                    <div class="card-header d-flex">
                        <div class="h4 mt-auto mb-auto">問題一覧</div>
                        @if ($is_teacher)
                            <div class="ml-3 mt-auto mb-auto">
                                <a href="{{ url('classrooms/' . $classroom->id . '/create-task') }}">
                                    <button class="btn btn-primary btn-sm">+ 問題を追加する</button>
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr class="text-center">
                                <th class="align-middle">問題タイトル</th>
                                <th class="align-middle" style="width: 18%">提出期限</th>
                                <th class="align-middle" style="width: 15%">合格者数</th>
                                <th class="align-middle" style="width: 17%">合格までの平均提出数</th>
                            </tr>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>
                                        <a href="{{ url('classrooms/' . $classroom->id . '/tasks/' . $task->id) }}" class="text-secondary">
                                            {{ $task->title }}
                                        </a>
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $task->deadline }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $task->correct_cnt - 1 }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ round($task->submit_avg, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="card mb-5">
                    <div class="card-header d-flex">
                        <div class="h4 mt-auto mb-auto">参加者一覧</div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr><th class="w-50">名前</th><th class="w-50">学籍番号</th></tr>
                            @foreach ($members as $member)
                                <tr>
                                    <td class="w-50">{{ $member->name }}</td>
                                    <td class="w-50">{{ $member->student_number }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection