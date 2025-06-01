<?php

namespace App\Exports;

use App\Models\Tarefa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TarefasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return auth()->user()->tarefas()->get();
    }

    public function headings(): array
    {
        return [
            'Tarefa ID',
            'Tarefa',
            'Data limite',
            'Data da criação',
        ];
    }

    public function map($tarefa): array
    {
        return [
            $tarefa->id,
            $tarefa->tarefa,
            date('d/m/Y', strtotime($tarefa->data_limite)),
            date('d/m/Y', strtotime($tarefa->created_at)),
        ];
    }
}
