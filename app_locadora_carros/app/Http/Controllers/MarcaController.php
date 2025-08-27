<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    /**
     * The Marca model instance.
     *
     * @var \App\Models\Marca
     */
    protected $marca;
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $marcas = Marca::all();
        // $marcas = $this->with('modelos')->marca->all();
        $marcas = array();

        if ($request->has('atributos_modelos')) {
            $marcas = $this->marca->with('modelos:id,' . $request->atributos_modelos);
        } else {
            $marcas = $this->marca->with('modelos');
        }

        if ($request->has('filtro')) {
            $filtros = explode(';', $request->filtro);
            foreach ($filtros as $condicao) {
                $c = explode(':', $condicao);
                $marcas = $marcas->where($c[0], $c[1], $c[2]);
            }
        }

        if ($request->has('atributos')) {
            $marcas = $marcas->selectRaw($request->atributos);
        }

        $marcas = $marcas->get();

        return response()->json($marcas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->marca->rules(), $this->marca->feedback());

        $imagem = $request->file('imagem');

        $imagem_urn = $imagem->store('imagens/marcas', 'public');

        // $marca = Marca::create($request->all());
        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);

        return response()->json($marca, 201);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Marca  $marca
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Marca $marca)
    // {
    //     return $marca;
    // }
    /**
     * Display the specified resource.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->with('modelos')->find($id);
        if (!$marca) {
            return response()->json(['erro' => 'Marca não encontrada!'], 404);
        }
        return response()->json($marca, 200);
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Marca  $marca
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Marca $marca)
    // {
    //     $marca->update($request->all());
    //     return $marca;
    // }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);

        if (!$marca) {
            return response()->json(['erro' => 'Marca não encontrada!'], 404);
        }

        if ($request->method() === 'PATCH') {
            $rules = [];
            foreach ($marca->rules() as $input => $rule) {
                if (array_key_exists($input, $request->all())) {
                    $rules[$input] = $rule;
                }
            }
            $request->validate($rules, $marca->feedback());
        } else {
            $request->validate($marca->rules(), $marca->feedback());
        }

        // Remove o arquivo antigo caso exista
        if ($request->file('imagem')) {
            if ($marca->imagem && Storage::disk('public')->exists($marca->imagem)) {
                Storage::disk('public')->delete($marca->imagem);
            }
        }
        // else {
        //     return response()->json(['erro' => 'É necessário enviar uma imagem!'], 400);
        // }

        $imagem = $request->file('imagem');

        $imagem_urn = $imagem->store('imagens/marcas', 'public');
        // $marca = Marca::create($request->all());
        $request->validate($this->marca->rules(), $this->marca->feedback());

        $marca->fill($request->all());
        $marca->imagem = $imagem_urn;
        $marca->save();

        // $marca->update([
        //     'nome' => $request->nome,
        //     'imagem' => $imagem_urn
        // ]);

        return response()->json($marca, 200);
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Marca  $marca
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Marca $marca)
    // {
    //     $marca->delete();
    //     return ['msg' => 'Marca deletada com sucesso!'];
    // }
    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = $this->marca->findOrFail($id);

        if (!$marca) {
            return response()->json(['erro' => 'Marca não encontrada!'], 404);
        }

        if ($marca->imagem) {
            Storage::disk('public')->delete($marca->imagem);
        }

        $marca->delete();
        return response()->json(['msg' => 'Marca deletada com sucesso!'], 200);
    }
}
