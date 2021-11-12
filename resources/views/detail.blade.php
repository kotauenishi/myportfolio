@extends('layouts.app')

@section('content')
    <h1>依頼タイトル</h1>

    <table class="table">
        <tr>
            <th>URL</th>
            <th>購入金額</th>
            <th>個数</th>
            <th>購入した日</th>
            <th>発送された日</th>
            <th>送料</th>
            <th>合計金額</th>
            <th>備考欄</th>
            <th>取引状況</th>
        </tr>
        <tr>
        <div class="tooltip1">
            <td><a href="{{htmlspecialchars($order->item_name)}}" target="_blank">{{htmlspecialchars($order->item_name)}}</a></td>
            <div class="description1"><p>通販サイトに移動します</p></div>
</div>
            <td>{{$order->price}}</td>
            <td>{{$order->count}}</td>
            <td>{{$order->buying_date}}</td>
            <td>{{$order->shipping_date}}</td>
            <td>{{$order->shipping_cost}}</td>
            <td>{{$order->price * $order->count + $order->shipping_cost}}</td>
            <td>{{htmlspecialchars($order->message)}}</td>
            @if($order->buying_complete == 1)
            <td>取引完了</td>
            @else
            <td>取引未完了</td>
            @endif
        </tr>
    </table>
<table class="table"> 
@if(Auth::user()->id != $order->user_id)
<tr><th>  購入通知ページへ</th>
<td>
    <div class="btn-group tooltip1">
       <form action="{{route('purchaseView',$order->id,$order->user_id)}}" method="GET">
           <input type="hidden" name="id" id="id" value="{{{htmlspecialchars($order->id)}}}">
           <input type="hidden" name="user_id" id="user_id" value="{{{htmlspecialchars($order->user_id)}}}">
           <input type="submit" value="購入完了処理">
       </form>
       <div class="description1">購入完了通知メールの入力フォームに遷移</div>
    </div>
</td>
</tr>
<tr><th> 発送通知ページへ</th>
<td>
    <div class="btn-group tooltip1">
    <form action="{{route('shippingView',$order->id,$order->user_id)}}" method="GET">
           <input type="hidden" name="id" id="id" value="{{{htmlspecialchars($order->id)}}}">
           <input type="hidden" name="user_id" id="user_id" value="{{{htmlspecialchars($order->user_id)}}}">
           <input type="submit" value="発送完了処理">
       </form>
       <div class="description1">発送完了通知メールの入力フォームに遷移</div>
    </div>
</td>
</tr>
@endif
@if(Auth::user()->id == $order->user_id)
<tr>
    <th>受取通知を行う</th>
    <td>
        <div class="btn-group tooltip1">
    <form action="{{route('receiveView',$order->id)}}" method="GET">
           <input type="hidden" name="id" id="id" value="{{{$order->id}}}">
           <input type="submit" value="受取完了処理">
       </form>
       <div class="description1">受取完了通知メールの入力フォームに遷移</div>
    </div>
</td>
</tr>
@endif
</table>

    <a href="{{route('index.index')}}">back</a>
    
   
    
@endsection
