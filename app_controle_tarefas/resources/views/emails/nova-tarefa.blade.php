@component('mail::message')
    # {{ $tarefa }}

    Data limide de conclusão: {{$data_limite_conclusao}}

    @component('mail::button', ['url' => $url])
        Ver tarefa
    @endcomponent
 
    Atenciosamente,<br>
    {{ config('app.name') }}
@endcomponent
