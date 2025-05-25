@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Adicionar Tarefa</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('tarefa.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="tarefa" class="form-label">Tarefa</label>
                                <input type="text" id="tarefa"
                                    class="form-control @error('tarefa') is-invalid @enderror" name="tarefa"
                                    value="{{ old('tarefa') }}">
                                @error('tarefa')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="data-limite" class="form-label">Data limite</label>
                                <input type="date" id="data-limite"
                                    class="form-control @error('data_limite') is-invalid @enderror" name="data_limite"
                                    value="{{ old('data_limite') }}">
                                @error('data_limite')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end align-items-center mt-4">
                                <a href="{{ url()->previous() }}" class="btn btn-light mr-3">Voltar</a>
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
