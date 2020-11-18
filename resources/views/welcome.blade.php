@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="w-100 mt-3 mb-3 text-center">
                <h3>オンラインジャッジを用いたプログラミング授業支援システム</h3>
            </div>
            <div class="col-sm-12 mt-5 text-center">
                <h4>説明</h4>
                <div class="mx-auto col-md-8">
                    <button onclick="location.href='#'" class="btn btn-primary col-md-4 col-5 mr-2">学生向け</button>
                    <button onclick="location.href='teachers-guide'" class="btn btn-secondary col-md-4 col-5 ml-2">教師向け</button>
                </div>
                <div class="mx-auto mt-5">
                    <h4>まずは <b>新規登録</b> / <b>ログイン</b> しよう！</h4>
                    <img src="images/welcome-st-1.png" alt="" class="col-lg-10 border shadow mb-3 xm-2">
                    <p>画面右上のリンクから 新規登録 / ログイン ができます。</p>
                </div>
                <div class="mx-auto mt-5">
                    <h4><b>クラスに参加</b>しよう！</h4>
                    <img src="images/welcome-st-2.png" alt="" class="col-md-10 col-lg-6 border shadow mb-3">
                    <img src="images/welcome-st-3.png" alt="" class="col-md-10 col-lg-5 border shadow mb-3">
                    <p>「クラスに参加する」ボタンをクリックした後、教員から与えられた「クラスコード」を入力してください。</p>
                </div>
                <div class="mx-auto mt-5">
                    <h4>問題（課題）を解こう！</h4>
                    <img src="images/welcome-st-4.png" alt="" class="col-md-10 col-lg-8 border shadow mb-3">
                    <p>「問題一覧」から対象の問題をクリックしてください。</p>
                    <p>問題には期限が設定されている場合がありますが、期限超過後も提出は可能です。復習等にご活用ください。</p>
                </div>
                <div class="mx-auto mt-5">
                    <h4>コードを提出しよう！</h4>
                    <img src="images/welcome-st-5.png" alt="" class="col-lg-10 border shadow mb-3">
                    <p>「問題文」や「ヒント」の内容をもとにコードを記述しましょう。</p>
                    <p>ブラウザ内のエディタ(赤枠)に直接記述し、「提出する」ボタンをクリックしてください。</p>
                    <p class="text-danger">クラス名は「Main」にしてください。</p>
                </div>
                <div class="mx-auto mt-5">
                    <h4>結果を確認しよう！</h4>
                    <img src="images/welcome-st-6.png" alt="" class="col-lg-10 border shadow mb-3">
                    <p>「提出一覧」画面では正解したかどうかの判定がわかります。</p>
                    <p>「詳細」リンクをクリックするとコードやエラー内容などが確認できます。</p>
                </div>
                <div class="mx-auto mt-5">
                    <h4>質問をしよう！</h4>
                    <img src="images/welcome-st-7.png" alt="" class="col-lg-10 border shadow mb-3">
                    <p>「質問」画面ではチャットの要領で質問ができます。</p>
                    <p>赤枠内に入力後、「投稿する」ボタンを押すことで投稿できます。</p>
                    <p>投稿内容は他のユーザーからも確認できますので、個人的な内容は書き込まないでください。</p>
                </div>
            </div>
        </div>    
    </div>
@endsection