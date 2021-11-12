@component('mail::message')
# Introduction

{{{htmlspecialchars($user)}}}があなたの依頼した商品を購入しました。<br>

￥{{$price}}で{{$count}}個購入しました。<br>

{{{htmlspecialchars($message)}}} <br>

@component('mail::button', ['url' => ''])
詳細画面へ
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent