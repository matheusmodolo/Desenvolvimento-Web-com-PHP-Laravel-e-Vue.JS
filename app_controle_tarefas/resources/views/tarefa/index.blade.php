@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        Tarefas
                        <div>
                            <a href="{{ route('tarefa.exportacao', ['extensao' => 'csv']) }}" class="btn btn-sm btn-secondary">CSV</a>
                            <a href="{{ route('tarefa.exportacao', ['extensao' => 'xlsx']) }}" class="btn btn-sm btn-secondary">XLSX</a>
                            <a href="{{ route('tarefa.exportacao', ['extensao' => 'pdf']) }}" class="btn btn-sm btn-secondary">PDF</a>
                            <a href="{{ route('tarefa.exportar') }}" target="_blank" class="btn btn-sm btn-secondary">PDF v2</a>
                            <a href="{{ route('tarefa.exportar') }}" class="btn btn-sm btn-primary">Adicionar</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Tarefa</th>
                                    <th scope="col">Data Limite</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tarefas as $tarefa)
                                    <tr>
                                        <td>{{ $tarefa->id }}</td>
                                        <td>{{ $tarefa->tarefa }}</td>
                                        <td>{{ date('d/m/Y', strtotime($tarefa->data_limite)) }} </td>
                                        <td><a href="{{ route('tarefa.edit', $tarefa->id) }}">Editar</a></td>
                                        <td>
                                            <form id="form_{{ $tarefa->id }}"
                                                action="{{ route('tarefa.destroy', $tarefa->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="#"
                                                    onclick="document.getElementById('form_{{ $tarefa->id }}').submit()">Excluir</a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <nav>
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="{{ $tarefas->previousPageUrl() }}">Anterior</a>
                                </li>

                                @for ($i = 1; $i <= $tarefas->lastPage(); $i++)
                                    {{-- <li class="page-item @if ($i == $tarefas->currentPage()) active @endif" aria-label="Page {{ $i }})"> --}}
                                    <li class="page-item {{ $i == $tarefas->currentPage() ? 'active' : '' }}"
                                        aria-label="Page {{ $i }})">
                                        <a class="page-link" href="{{ $tarefas->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <li class="page-item">
                                    <a class="page-link" href="{{ $tarefas->nextPageUrl() }}">Próximo</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
