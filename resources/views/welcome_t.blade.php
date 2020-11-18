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
                    <button onclick="location.href='/'" class="btn btn-secondary col-md-4 col-5 mr-2">学生向け</button>
                    <button onclick="location.href='#'" class="btn btn-primary col-md-4 col-5 ml-2">教師向け</button>
                </div>
                <div class="mx-auto mt-5">
                    <h4><b>新規登録</b> / <b>ログイン</b></h4>
                    <img src="images/welcome-st-1.png" alt="" class="col-lg-10 border shadow mb-3 xm-2">
                    <p>画面右上のリンクから 新規登録 / ログイン ができます。</p>
                </div>
                <div class="mx-auto mt-5">
                    <h4>自分のクラスを作成する</h4>
                    <img src="images/welcome-te-2.png" alt="" class="col-lg-10 border shadow mb-3 xm-2">
                    <p>「新しいクラスを作成する」ボタンをクリックしてください。</p>
                    <p>その後、自身のクラスの表示名を入力し、「作成する」ボタンをクリックしてください。</p>
                </div>
                <div class="mx-auto mt-5">
                    <h4>学生を参加させる</h4>
                    <img src="images/welcome-te-3.png" alt="" class="col-md-10 col-lg-6 border shadow mb-3 xm-2">
                    <img src="images/welcome-te-4.png" alt="" class="col-md-10 col-lg-5 border shadow mb-3 xm-2">
                    <p>学生を参加させるにはクラス画面から「クラスの詳細を編集する」をクリックします。</p>
                    <p>クラス詳細編集画面に表示されている「クラスコード」をもとに学生はクラスを検索します。</p>
                    <p>「クラスコード」である英数字8文字をコピーするなどして、学生に通達してください。</p>
                </div>
                <div class="mx-auto mt-5">
                    <h4>問題（課題）を設定する</h4>
                    <img src="images/welcome-te-5.png" alt="" class="col-lg-10 border shadow mb-3 xm-2">
                    <p>「問題を追加する」ボタンをクリックし、問題作成画面へと遷移します。</p>
                    <img src="images/welcome-te-6.png" alt="" class="col-lg-10 border shadow mb-3 xm-2">
                    <p>その後、必要に応じて「ヒント」や「入力値」等も含めて問題情報を入力してください。</p>
                    <p>画像のように、入力を与える必要がある問題では、「入力値」に入力した内容が標準入力より提出プログラムに与えられます。</p>
                    <p>入力値が複数ある場合は、空白区切りもしくは改行区切りで入力してください。</p>
                    <p class="text-danger">「提出期限」を設定しない場合、学生は自由に模範解答を閲覧可能になります。課題として問題を作成する場合は必ず提出期限を設定してください。</p>
                    <p>「提出期限」超過後は学生は自由に模範解答を閲覧可能になります。</p>
                </div>
                <div class="mx-auto mt-5">
                    <h4>模範解答を設定する</h4>
                    <img src="images/welcome-te-7.png" alt="" class="col-lg-10 border shadow mb-3 xm-2">
                    <p>「問題一覧」から対象の問題をクリックしてください。</p>
                    <p>模範解答を設定するには、赤枠内のエディタに直接模範解答となるコードを記述し、「提出する」ボタンをクリックします。</p>
                    <p>「提出する」ボタンをクリックすると模範解答登録に関する注意事項がポップアップに表示されますので、ご了承の上「OK」ボタンをクリックすることで設定完了となります。</p>
                    <p>なお、模範解答として投稿したコードに対しても正誤判定が行われますので、<span class="text-danger">「正解」となっていることを確認</span>してください。</p>
                    <p>「不正解」の場合は、問題文上部の「模範解答」タブをクリックすることで、コードと出力内容を確認できますので、ご確認ください。</p>
                    <p>模範解答はコードを提出するたびに上書きされるので、不正解となった場合でもご安心ください。</p>
                </div>
                <div class="mx-auto mt-5">
                    <h4>提出状況を確認する</h4>
                    <img src="images/welcome-te-8.png" alt="" class="col-lg-10 border shadow mb-3 xm-2">
                    <p>学生の提出状況を確認するには「提出状況一覧」タブをクリックしてください。</p>
                    <p>ここでは、1度でも正解した学生のみが表示されることに注意してください。</p>
                    <p>「合格」の欄には提出期限内に正解した場合に「〇」と表示されます。</p>
                    <p>また、提出期限が設定されていない場合は提出日時に係わらず、正解すれば「合格」の欄に「〇」が表示されます。</p>
                    <p>「提出期限後に正解」では、提出期限内に正解できなかったが、提出期限後に正解した学生に「〇」が表示されます。</p>
                    <p>学生の「名前」をクリックすると、当該学生の提出一覧へのリンクとなります。</p>
                </div>
                <div class="mx-auto mt-5">
                    <h4>質問に応答する</h4>
                    <img src="images/welcome-te-9.png" alt="" class="col-lg-10 border shadow mb-3 xm-2">
                    <p>「質問」画面では掲示板やチャットの要領で学生と質問のやり取りができます。</p>
                    <p>赤枠内に入力後、「投稿する」ボタンをクリックすることで投稿できます。</p>
                    <p>投稿内容はクラスの参加者全体から確認できますので、個人的な内容は書き込まないようにお願いします。</p>
                </div>
            </div>
        </div>    
    </div>
@endsection