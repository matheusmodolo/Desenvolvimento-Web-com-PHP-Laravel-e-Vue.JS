<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

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
    public function index()
    {
        // $marcas = Marca::all();
        $marcas = $this->marca->all();
        return $marcas;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $marca = Marca::create($request->all());
        $marca = $this->marca->create($request->all());
        return $marca;
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
        $marca = $this->marca->findOrFail($id);
        return $marca;
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
        $marca = $this->marca->findOrFail($id);
        $marca->update($request->all());
        return $marca;
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
        $marca->delete();
        return ['msg' => 'Marca deletada com sucesso!'];
    }
}
