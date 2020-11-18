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
            <div class="col-md-10 col-lg-8">
                <div class="card">
                    <div class="card-header">クラスに参加する</div>

                    <div class="card-body">
                        <form method="post" action="{{ url('classrooms/register') }}">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <strong class="col-md-4 text-md-right"><span class="text-danger">※</span>は必須項目</strong>
                            </div>

                            <div class="form-group row mb-5">
                                <label for="class_code" class="col-md-4 col-form-label text-md-right"><span class="text-danger">※</span>クラスコード</label>
                                <div class="col-md-6">
                                    <input type="text" name="class_code" id="class_code" class="w-100">
                                    <span id="class_code" class="form-text text-muted">8文字の英数列<br>大文字小文字を区別します</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12  d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">参加する</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection