@extends('layouts.app')

@section('content')



<h1>代行依頼を作成します</h1>
@if(count($errors) > 0)
<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif
<form action="{{{route('index.store')}}}" method="POST">
    @csrf
    <div class="form-group">
        <label for="title">
            依頼タイトル
        </label>
        <input type="text" name="title" id="title" class="form-control">
    </div>
    <br>

    <div class="form-group">
        <label for="title">
            通販サイトのURL
        </label>
        <input type="text" name="item_name" id="item_name" class="form-control">
    </div>
    <br>
    <div class="form-group">
        <label for="title">
            個数
        </label>
        <input type="text" name="count" id="count" class="form-control">
    </div>
    <br>
    <div class="form-group">
        <label for="title">
            商品のお値段(通販サイトに明記されている金額を記入してください)
        </label>
        <input type="text" name="price" id="price" class="form-control">
    </div>
    <br>

    <p>住所</p>
    <textarea name="message" id="message" cols="30" rows="10">
    ここに住所を記入してください
</textarea>
    <br>
    <input type="submit" value="送信">
</form>
<a href="{{route('index.index')}}">back</a>

@endsection