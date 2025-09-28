<?php

namespace App\Http\Controllers;

use App\Models\Enrollments;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EnrollmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $enrollments = Enrollments::all();
            return response()->json($enrollments);
        
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudieron obtener las inscripciones',
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
                'enrollment_academic_year' => 'required|date_format:Y',
                'user_id' => 'required|int',
                'subject_id' => 'required|int',
                'commission_id' => 'required|int'
            ]));
            $enrollment = Enrollments::create($request->all());
            return response()->json([
                'message' => 'Inscripción creada exitosamente',
                'data' => $enrollment,
            ], 201);
        
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'No se pudo crear la inscripción, verifique la validez de los datos enviados',
                'error' => $e->validator->errors()
            ], 422);
        
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudo crear la inscripción',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $enrollment = Enrollments::findOrFail($id);
            return response()->json($enrollment);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'La inscripción solicitada no existe'
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudo obtener la inscripción',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollments $enrollments)
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
                'enrollment_academic_year' => 'required|date_format:Y',
                'user_id' => 'required|int',
                'subject_id' => 'required|int',
                'commission_id' => 'required|int'
            ]));
            $enrollment = Enrollments::findOrFail($id);
            $enrollment->update($request->all());
            return response()->json([
                'message' => 'Inscripción actualizada exitosamente',
                'data' => $enrollment,
            ], 201);
        
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'No se pudo actualizar la inscripción, verifique la validez de los datos enviados',
                'error' => $e->validator->errors()
            ], 422);
        
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'La inscripción solicitada no existe'
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudo actualizar la inscripción',
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
            $enrollment = Enrollments::findOrFail($id);
            $enrollment->delete();
            return response()->json([
                'message' => 'Inscripción eliminada exitosamente',
                'data' => $enrollment,
            ], 200);
        
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'La inscripción solicitada no existe'
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudo eliminar la inscripción',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
