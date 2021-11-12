@extends('layouts.app')

@section('title','Index')


@section('content')

<div class="col-sm-4" style="padding:20px 0; padding-left:0px; float:right; margin-right:200px">
    <form class="form-inline" action="{{route('index.index')}}" method="get">
        <div class="form-group tooltip1">
            <input type="text" name="keyword" value="" class="form-control" placeholder="依頼を検索します">
            <div class="description1">キーワードで検索</div>
        </div>
        <div class="form-group tooltip1">
            <input type="date" name="start_date" value="" class="form-control" placeholder="YY-mm-dd">

            <span class="mx-3 text-grey">~</span>

            <input type="date" name="end_date" value="" class="form-control" placeholder="YY-mm-dd">
            <div class="description1">日時、期間で検索</div>
            <input type="submit" value="検索" class="btn btn-info">
        </div>
    </form>
</div>

<h1>マイページ</h1>

<h2>取引合計金額</h2>




<table class="table">
    <thead>
        <tr>
            @if(!empty(Auth::User()->admin))
            <th scope="col">依頼を受けた総額</th>
            @else
            <th scope="col">依頼を行った総額</th>
            @endif
        </tr>
    </thead>
    <tbody>
        <tr>
            @if(!empty(Auth::User()->admin))
            <td>
                <?php $seller_total = 0 ?>
                @foreach($seller_datas as $seller_data)
                <?php
                $seller_total += $seller_data->price * $seller_data->count + $seller_data->shipping_cost;
                ?>
                @endforeach
                ¥<?php echo $seller_total ?>
            </td>
            @endif
            <td>
                <?php $buyer_total = 0 ?>
                @foreach($buyer_datas as $buyer_data)
                <?php
                $buyer_total += $buyer_data->price * $buyer_data->count + $buyer_data->shipping_cost;
                ?>
                @endforeach
                ¥<?php echo $buyer_total ?>
            </td>
        </tr>



    </tbody>
</table>
@if(empty(Auth::User()->admin))
<div class="tooltip1">
    <a href="{{route('index.create')}}">新規依頼を作成する</a>
    <div class="description1">新規依頼作成フォームに遷移します。</div>
</div>
@endif
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">日付</th>
            <th scope="col">依頼タイトル</th>
            <th scope="col">依頼者</th>
            <th scope="col">詳細</th>
        </tr>

    </thead>
    <tbody>

        @foreach($orders as $order)
        <tr>
            <td>{{$order->id}}</td>
            <td>{{$order->order_date}}</td>
            <td>{{htmlspecialchars($order->title)}}</td>
            <td>{{htmlspecialchars($order->name)}}</td>
            <td>
                <div class="tooltip1">
                    <form action="{{route('index.show',$order->id)}}" method="GET">
                        <input type="hidden" name="id" id="id" value="{{{htmlspecialchars($order->id)}}}">
                        <input type="submit" value="詳細画面へ">
                    </form>
                    <div class="description1">詳細画面へ遷移します。</div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{{$orders->links()}}}
@endsection