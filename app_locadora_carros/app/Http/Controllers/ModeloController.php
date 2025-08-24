<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    protected $modelo;
    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelos = $this->modelo->with('marca')->get();
        return response()->json($modelos, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->modelo->rules());

        $imagem = $request->file('imagem');

        $imagem_urn = $imagem->store('imagens/modelos', 'public');

        $modelo = $this->modelo->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
            'marca_id' => $request->marca_id,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);

        return response()->json($modelo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelo = $this->modelo->with('marca')->find($id);
        if (!$modelo) {
            return response()->json(['erro' => 'Modelo não encontrado!'], 404);
        }
        return response()->json($modelo, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $modelo = $this->modelo->find($id);

        if (!$modelo) {
            return response()->json(['erro' => 'Modelo não encontrado!'], 404);
        }

        if ($request->method() === 'PATCH') {
            $rules = [];
            foreach ($modelo->rules() as $input => $rule) {
                if (array_key_exists($input, $request->all())) {
                    $rules[$input] = $rule;
                }
            }
            $request->validate($rules);
        } else {
            $request->validate($modelo->rules());
        }

        // Remove o arquivo antigo caso exista
        if ($request->file('imagem')) {
            if ($modelo->imagem && Storage::disk('public')->exists($modelo->imagem)) {
                Storage::disk('public')->delete($modelo->imagem);
            }
        }
        // else {
        //     return response()->json(['erro' => 'É necessário enviar uma imagem!'], 400);
        // }

        $imagem = $request->file('imagem');

        $imagem_urn = $imagem->store('imagens/modelos', 'public');

        $request->validate($this->modelo->rules());

        $modelo->fill($request->all());
        $modelo->imagem = $imagem_urn;
        $modelo->save();

        // $modelo->update([
        //     'nome' => $request->nome,
        //     'imagem' => $imagem_urn,
        //     'marca_id' => $request->marca_id,
        //     'numero_portas' => $request->numero_portas,
        //     'lugares' => $request->lugares,
        //     'air_bag' => $request->air_bag,
        //     'abs' => $request->abs
        // ]);

        return response()->json($modelo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo = $this->modelo->findOrFail($id);

        if (!$modelo) {
            return response()->json(['erro' => 'Modelo não encontrado!'], 404);
        }

        if ($modelo->imagem) {
            Storage::disk('public')->delete($modelo->imagem);
        }

        $modelo->delete();
        return response()->json(['msg' => 'Modelo deletado com sucesso!'], 200);
    }
}
