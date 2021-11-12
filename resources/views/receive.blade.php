@extends('layouts.app')

@section('content')

<h1>受取通知を行います</h1>

<form action="{{route('receive')}}" method="POST">
    @csrf
    <input type="hidden" name="buying_complete" value="1">
    <input type="hidden" name="id" value="{{{$_GET['id']}}}">

    <p>備考欄</p>
    <textarea name="message" id="message" cols="30" rows="10">
    ここに必要事項を記入してください
</textarea>
    <br>
    <input type="submit" value="送信">
</form>
<a href="{{route('index.index')}}">back</a>
@endsection