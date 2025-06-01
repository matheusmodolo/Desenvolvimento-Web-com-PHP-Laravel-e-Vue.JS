<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .titulo {
            text-align: center;
            padding: .7rem;
            border: 1px solid #000;
            background-color: #c2c2c2;
            width: 100%;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .tabela {
            width: 100%;
        }

        table th {
            text-align: left;
            padding: .5rem;
            border: 1px solid #000;
            background-color: #c2c2c2;
        }

        /* .page-break {
            page-break-after: always;
        } */
    </style>

</head>

<body>
    <div class="titulo">Tarefas</div>
    <table class="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tarefa</th>
                <th>Data Limite</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tarefas as $tarefa)
                <tr>
                    <td>{{ $tarefa->id }}</td>
                    <td>{{ $tarefa->tarefa }}</td>
                    <td>{{ date('d/m/Y', strtotime($tarefa->data_limite)) }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Quebrando a Página --}}
    {{-- <div class="page-break"></div> --}}

</body>

</html>
