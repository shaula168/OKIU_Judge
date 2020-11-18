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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card">
                    <div class="card-header">クラス詳細編集</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <strong class="col-md-4 text-md-right"><span class="text-danger">※</span>は必須項目</strong>
                        </div>

                        <div class="form-group row mb-5">
                            <label for="id" class="col-md-4 col-form-label text-md-right">クラスコード</label>
                            <div class="col-md-6">
                                <input type="text" name="code" id="code" class="w-100" readonly="readonly" value="{{ $classroom->classroom_code }}">
                                <span id="code" class="form-text text-muted">クラスコードは変更できません！<br>参加者が参加登録時にクラスコードで検索を行います。</span>
                            </div>
                        </div>

                        <form method="post" action="{{ route('classrooms.update', $classroom->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="form-group row mb-5">
                                <label for="title" class="col-md-4 col-form-label text-md-right"><span class="text-danger">※</span>クラス名</label>
                                <div class="col-md-6">
                                    <input type="text" name="title" id="title" class="w-100" value="{{ $classroom->title }}">
                                    <span id="title" class="form-text text-muted">1~50文字以内</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12  d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">更新する</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection