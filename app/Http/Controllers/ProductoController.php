<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $producto = Producto::with(['user:id,email,name'])->paginate(3);
        $productos = Producto::with(['user:id,email,name'])
                            ->whereCodigo($request->txtBuscar)
                            ->orWhere('nombre', 'like', "%{$request->txtBuscar}%" )->paginate(2);
        return \response()->json($productos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductoRequest $request)
    {
        // $producto = Producto::create($request->all());
        // return \response()->json($producto, 201);
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $producto = Producto::create($input);
        return response()->json(['message   ' => 'Insertado correctamente'], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productos = Producto::with(['user:id,email,name'])->findOrFail($id);
        return \response()->json($productos, 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductoRequest $request, $id)
    {
        $producto = Producto::find($id);
        $producto->update($request->all());
        return \response()->json($producto, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Producto::destroy($id);
        return response()->json(['message' => 'Producto eliminado correctamente'], 200);

    }
    
    public function setLike($id)
    {
        $producto = Producto::find($id);
        $producto->like = $producto->like + 1;
        $producto->save();
        return response()->json(['message' => 'Like añadido correctamente'], 200);
    }

    public function setDisLike($id)
    {
        $producto = Producto::find($id);
        $producto->dislike = $producto->dislike + 1;
        $producto->save();
        return response()->json(['message' => 'Dislike añadido correctamente'], 200);
    }

    public function setImagen(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->imagen = $this->cargarImagen($request->imagen, $id);
        $producto->save();
        return response()->json(['res' => true, 'message' => 'Imagen añadida correctamente'], 200);
    }

    private function cargarImagen($file, $id)
    {   // laravel acepta fotos con put, pero en el postman hay que utilizar el metodo post y abajo en key, añadir
        // _method=PUT
        $nombre = time() . "_{$id}." . $file->getClientOriginalExtension();
        $file->move(public_path('imagenes'), $nombre);
        return $nombre;
    }
}   
