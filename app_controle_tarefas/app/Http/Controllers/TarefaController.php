<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use App\Mail\NovaTarefaMail;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TarefasExport;

class TarefaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tarefas = Tarefa::where('user_id', auth()->user()->id)->orderBy('data_limite', 'desc')->paginate(10);
        return view('tarefa.index', ['tarefas' => $tarefas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tarefa' => 'required|min:3',
            'data_limite' => 'required|date'
        ], [
            'tarefa.required' => 'O campo Tarefa é obrigatório',
            'tarefa.min' => 'O campo Tarefa deve ter no mínimo 3 caracteres',
            'data_limite.required' => 'O campo Data Limite é obrigatório',
            'data_limite.date' => 'O campo Data Limite deve ser uma data válida'
        ]);

        $dados = $request->all();
        $dados['user_id'] = auth()->user()->id;
        $tarefa = Tarefa::create($dados);

        $destinatario = auth()->user()->email;
        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));

        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function show(Tarefa $tarefa)
    {
        return view('tarefa.show', ['tarefa' => $tarefa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;
        if ($tarefa->user_id == $user_id) {
            return view('tarefa.edit', ['tarefa' => $tarefa]);
        }
        return view('acesso-negado');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;
        if ($tarefa->user_id != $user_id) {
            return view('acesso-negado');
        }

        $request->validate([
            'tarefa' => 'required|min:3',
            'data_limite' => 'required|date'
        ], [
            'tarefa.required' => 'O campo Tarefa é obrigatório',
            'tarefa.min' => 'O campo Tarefa deve ter no mínimo 3 caracteres',
            'data_limite.required' => 'O campo Data Limite é obrigatório',
            'data_limite.date' => 'O campo Data Limite deve ser uma data válida'
        ]);
        $tarefa->update($request->all());
        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;
        if ($tarefa->user_id != $user_id) {
            return view('acesso-negado');
        }
        $tarefa->delete();
        
        return redirect()->route('tarefa.index');
    }

    public function exportacao(){
        return Excel::download(new TarefasExport, 'tarefas.xlsx');
    }
}
