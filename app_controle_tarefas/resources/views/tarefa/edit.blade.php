@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Atualizar Tarefa</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('tarefa.update', $tarefa->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="tarefa" class="form-label">Tarefa</label>
                                <input type="text" id="tarefa"
                                    class="form-control @error('tarefa') is-invalid @enderror" name="tarefa"
                                    value="{{ $tarefa->tarefa ?? old('tarefa') }}">
                                @error('tarefa')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="data-limite" class="form-label">Data limite</label>
                                <input type="date" id="data-limite"
                                    class="form-control @error('data_limite') is-invalid @enderror" name="data_limite"
                                    value="{{ $tarefa->data_limite ?? old('data_limite') }}">
                                @error('data_limite')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
