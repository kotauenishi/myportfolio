@extends('layouts.app')

@section('content')

<body>


    <h1>アカウントの登録内容を変更します。</h1>
    @if(!empty($msg))
    <p>{{$msg}}</p>
    @endif
    <form action="{{{route('index.update',auth()->user()->id)}}}" method="POST">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="title">
                新しいメールアドレス
            </label>
            <input type="text" name="email" id="email" class="form-control" placeholder="{{{auth()->user()->email}}}">
        </div>
        <br>

        <div class="form-group">
            <label for="title">
                新しいパスワード
            </label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <br>

        <div class="form-group">
            <label for="title">
                現在のパスワード
            </label>
            <input type="password" name="old_password" id="old_password" class="form-control">
        </div>
        <br>
        <input type="submit" value="送信">
    </form>
    <a href="{{route('index.index')}}">back</a>
</body>
@endsection