<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Controle de Tarefas')
<img src="http://localhost:8000/img/logo.png" class="logo" alt="Controle de Tarefas Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
