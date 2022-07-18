@component('mail::message')
# Пользователь отправил свои контактные данные
@if(isset($data['name']))Фио: {{$data['name']}}  @endif
@if(isset($data['email']))Email: {{$data['email']}}  @endif
@if(isset($data['phone']))Телефон: {{$data['phone']}}  @endif

@endcomponent
