<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;

class ProductosController extends Controller
{

    //devuelve todos los productos registrados

    public function index()
    {
        $productos = Productos::all();

        return response()->json($productos);
    }


    // Crear un nuevo producto
    public function AgregarProd(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'precio' => 'required|numeric',
        ]);

        // Crear el producto
        $producto = Productos::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
        ]);

        return response()->json($producto, 201); // 201 Created
    }


    // Mostrar un producto específico
    public function VerPro($id)
    {
        $producto = Productos::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto);
    }


    // Actualizar un producto
    public function EditarPro(Request $request, $id)
    {
        $producto = Productos::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        // Validar los datos de entrada
        $request->validate([
            'nombre' => 'string|max:255',
            'descripcion' => 'string|max:1000',
            'precio' => 'numeric',
        ]);

        // Actualizar el producto
        $producto->update($request->only(['nombre', 'descripcion', 'precio']));

        return response()->json($producto);
    }


    // Eliminar un producto
    public function EliminarPro($id)
    {
        $producto = Productos::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $producto->delete();

        return response()->json(['message' => 'Producto eliminado con éxito']);
    }

}
