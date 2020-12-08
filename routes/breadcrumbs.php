<?php

// クラス一覧
Breadcrumbs::for('home', function ($trail) {
    $trail->push('クラス一覧', route('home'));
});

// クラス一覧 > クラスの新規作成
Breadcrumbs::for('create_classroom', function ($trail) {
    $trail->parent('home');
    $trail->push('クラスの新規作成');
});

// クラス一覧 > クラスに参加
Breadcrumbs::for('join_classroom', function ($trail) {
    $trail->parent('home');
    $trail->push('クラスに参加する');
});

// クラス一覧 > クラスの詳細
Breadcrumbs::for('show_classroom', function ($trail, $classroom) {
    $trail->parent('home');
    $trail->push($classroom->title, url('classrooms/' . $classroom->id));
});

// クラス一覧 > クラスの詳細 > クラスの編集
Breadcrumbs::for('edit_classroom', function ($trail, $classroom) {
    $trail->parent('show_classroom', $classroom);
    $trail->push('クラスの詳細編集');
});

// クラス一覧 > クラスの詳細 > 問題の新規作成
Breadcrumbs::for('create_task', function ($trail, $classroom) {
    $trail->parent('show_classroom', $classroom);
    $trail->push('問題の新規作成');
});

// クラス一覧 > クラスの詳細 > 問題の詳細
Breadcrumbs::for('show_task', function ($trail, $classroom, $task) {
    $trail->parent('show_classroom', $classroom);
    $trail->push($task->title, url('classrooms/' . $classroom->id . '/tasks/' . $task->id));
});

// クラス一覧 > クラスの詳細 > 問題の詳細 > 問題の編集
Breadcrumbs::for('edit_task', function ($trail, $classroom, $task) {
    $trail->parent('show_task', $classroom, $task);
    $trail->push('問題の編集');
});

// クラス一覧 > クラスの詳細 > 問題の詳細 > 質問
Breadcrumbs::for('issue_task', function ($trail, $classroom, $task) {
    $trail->parent('show_task', $classroom, $task);
    $trail->push('質問');
});

// クラス一覧 > クラスの詳細 > 問題の詳細 > 提出一覧
Breadcrumbs::for('submissions_task', function ($trail, $classroom, $task) {
    $trail->parent('show_task', $classroom, $task);
    $trail->push('提出一覧', url('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/submissions'));
});

// クラス一覧 > クラスの詳細 > 問題の詳細 > 提出一覧 > 提出詳細
Breadcrumbs::for('show_submit_task', function ($trail, $classroom, $task) {
    $trail->parent('submissions_task', $classroom, $task);
    $trail->push('提出詳細');
});

// クラス一覧 > クラスの詳細 > 問題の詳細 > 模範解答
Breadcrumbs::for('answer_task', function ($trail, $classroom, $task) {
    $trail->parent('show_task', $classroom, $task);
    $trail->push('模範解答');
});

// クラス一覧 > クラスの詳細 > 問題の詳細 > 順位表
Breadcrumbs::for('standings_task', function ($trail, $classroom, $task) {
    $trail->parent('show_task', $classroom, $task);
    $trail->push('順位表');
});

// クラス一覧 > クラスの詳細 > 問題の詳細 > 提出状況一覧
Breadcrumbs::for('status_list_task', function ($trail, $classroom, $task) {
    $trail->parent('show_task', $classroom, $task);
    $trail->push('提出状況一覧');
});