@extends('layouts.app')

@section('content')

<body>


    <h1>発送通知を行います</h1>
    @if(count($errors) > 0)
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif
    <form action="{{route('shipping')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">
                送料
            </label>
            <input type="text" name="shipping_cost" id="shipping_cost">
        </div>
        <br>
        <input type="hidden" name="id" value="{{{$_GET['id']}}}">
        <input type="hidden" name="user_id" value="{{{$_GET['user_id']}}}">

        <p>備考欄</p>
        <textarea name="message" id="message" cols="30" rows="10">
    ここに必要事項を記入してください（追跡番号などはこちらへ）
</textarea>
        <br>
        <input type="submit" value="送信">
    </form>

    <a href="{{route('index.index')}}">back</a>
</body>
@endsection