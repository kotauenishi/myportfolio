@extends('layouts.app')

@section('content')


<h1>購入通知を行います</h1>
@if(count($errors) > 0)
<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif
<form action="{{route('purchase')}}" method="POST">
    @csrf
    <div class="form-group">
        <label for="title">
            購入金額
        </label>
        <input type="text" name="price" id="price">
    </div>
    <div class="form-group">
        <label for="title">
            個数
        </label>
        <input type="count" name="count" id="count">
    </div>
    <br>
    <input type="hidden" name="id" value="{{{$_GET['id']}}}">
    <input type="hidden" name="user_id" value="{{{$_GET['user_id']}}}">

    <p>備考欄</p>
    <textarea name="message" id="message" cols="30" rows="10">
    ここに必要事項を記入してください
</textarea>
    <br>
    <input type="submit" value="送信">
</form>
<a href="{{route('index.index')}}">back</a>
@endsection