@component('mail::message')
# Introduction

{{{htmlspecialchars($user)}}}があなたの依頼した商品を発送しました。<br>

送料は￥{{$shipping_cost}}です。<br>

{{{htmlspecialchars($message)}}} <br>

@component('mail::button', ['url' => ''])
詳細画面へ
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent