<x-mail::message>
# Состояние сервиса

<p><b>Приложение:</b>{{ config('app.name') }}</p>
<p>{{ config('app.url') }}</p>

<x-mail::panel>
    <span style="color: #28a745; font-weight: bold;">Сервис работает исправно!</span>
</x-mail::panel>

Ваше приложение доступно и работает корректно. Нет ошибок или сбоев.

<x-mail::button :url="'#'">
    Перейти в панель управления
</x-mail::button>

</x-mail::message>