@component('mail::message')
# Introduction

{{htmlspecialchars($user)}}が商品を受け取りました<br>

{{htmlspecialchars($message)}} <br>

@component('mail::button', ['url' => ''])
詳細画面へ
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent