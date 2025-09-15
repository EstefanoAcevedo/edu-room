<?php

namespace App\Http\Controllers;

use App\Models\Subjects;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $subjects = Subjects::with('career')->get();
            return response()->json($subjects);
        
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudieron obtener las asignaturas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate(([
                'subject_name' => 'required|string|max:255|unique:subjects,subject_name',
                'career_id' => 'required|int'
            ]));
            $subject = Subjects::create($request->all());
            return response()->json([
                'message' => 'Asignatura creada exitosamente',
                'data' => $subject
            ], 201);
        
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'No se pudo crear la asignatura, verifique la validez de los datos enviados',
                'error' => $e->validator->errors()
            ], 422);
        }

        catch(Exception $e) {
            return response()->json([
                'message' => 'No se pudo crear la asignatura',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subjects $subjects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subjects $subjects)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate(([
                'subject_name' => 'required|string|max:255',
                'career_id' => 'required|int'
            ]));
            $subject = Subjects::find($id);
            $subject->update($request->all());
            return response()->json([
                'message' => 'Asignatura actualizada exitosamente',
                'data' => $subject
            ], 200);
        
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'No se pudo actualizar la asignatura, verifique la validez de los datos enviados',
                'error' => $e->validator->errors()
            ], 422);
        
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudo actualizar la asignatura',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $subject = Subjects::find($id);
            $subject->delete();
            return response()->json([
                'message' => 'Asignatura eliminada exitosamente',
                'data' => $subject
            ], 200);
        
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudo eliminar la asignatura',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
