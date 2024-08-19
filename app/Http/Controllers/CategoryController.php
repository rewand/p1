<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    // Listar todas las categorías, excluyendo fechas de creación y actualización
    public function get()
    {
        try {
            $categories = Category::where('regist_status', 'A')
                ->get();
            return response()->json(["data" => $categories, "size" => count($categories)], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => '' . $e,
            ], 500);
        }
    }
    public function show($id)
    {
        try {
            $category = Category::find($id);
            return response()->json($category, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => '' . $e,
            ], 500);
        }
    }
    public function store(Request $request)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'parent_id' => 'nullable|exists:categories,id',
            ]);
            $category = Category::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
            ]);
            DB::commit(); // Confirma la transacción
            return response()->json([
                'message' => 'Categoría creada con éxito',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
            return response()->json([
                'message' => '' . $e,
            ], 500);
        }
    }

    // Actualizar una categoría existente
    public function update(Request $request, $id)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            $category = Category::find($id);
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'parent_id' => 'nullable|exists:categories,id',
            ]);
            $category->update([
                'name' => $validatedData['name'],
                'parent_id' => $validatedData['parent_id'],
            ]);
            DB::commit(); // Confirma la transacción
            return response()->json([
                'message' => 'Categoría actualizada con éxito',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
            return response()->json([
                'message' => '' . $e,
            ], 500);
        }
    }
    public function delete($id)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            $category = Category::find($id);
            $category->update(['regist_status' => 'I']);
            DB::commit(); // Confirma la transacción
            return response()->json([
                'message' => 'Categoría marcada como inactiva con éxito'
            ], 204);
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
            return response()->json([
                'message' => '' . $e,
            ], 500);
        }
    }
}
