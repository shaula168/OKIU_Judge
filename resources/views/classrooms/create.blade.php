@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('create_classroom') }}
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
            <div class="col-md-10 col-lg-8">
                <div class="card">
                    <div class="card-header">新規問題作成</div>

                    <div class="card-body">
                        <form method="post" action="{{ route('classrooms.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <strong class="col-md-4 text-md-right"><span class="text-danger">※</span>は必須項目</strong>
                            </div>

                            <div class="form-group row mb-5">
                                <label for="title" class="col-md-4 col-form-label text-md-right"><span class="text-danger">※</span>クラス名</label>
                                <div class="col-md-6">
                                    <input type="text" name="title" id="title" class="w-100">
                                    <span id="title" class="form-text text-muted">1~50文字以内</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12  d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">作成する</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection