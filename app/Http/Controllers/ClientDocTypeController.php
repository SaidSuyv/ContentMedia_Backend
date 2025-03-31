<?php

namespace App\Http\Controllers;

use App\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ClientDocType;

class ClientDocTypeController extends Controller
{
    use ApiResponser;

    /**
     * Get all Client Document Types
     * 
     * @return Array[ClientDocType]
     */
    public function index()
    {
        $ClientDocTypes = ClientDocType::all();
        return $this->successResponse( $ClientDocTypes );
    }

    /**
     * Create a Client Document Type
     * @param Request
     * 
     * @return ClientDocType
     */
    public function store(Request $request)
    {
        $rules = [
            "name" => 'required|string'
        ];

        $this->validate( $request , $rules );

        $cdt = ClientDocType::create( $request->all() );

        return $this->successResponse( $cdt );
    }

    /**
     * Get one Client Document Type
     * @param String
     * 
     * @return ClientDocType || Null
     */
    public function show($cdt)
    {
        $cdt = ClientDocType::findOrFail($cdt);
        return $this->successResponse( $cdt );
    }

    /**
     * Update one Client Document Type
     * @param Request
     * @param String
     * 
     * @return ClientDocType
     */
    public function update(Request $request , $cdt)
    {
        $rules = ["name"=>"required|string"];
        $this->validate( $request , $rules );

        $cdt = ClientDocType::findOrFail( $cdt );

        $cdt->fill( $request->all() );

        if( $cdt->isClean() )
            return $this->errorResponse( "Al menos un valor debe ser cambiado" , Response::HTTP_UNPROCESSABLE_ENTITY );

        $cdt->save();

        return $this->successResponse( $cdt );
    }

    /**
     * Destroy one Client Document Types
     * @param String
     * 
     * @return ClientDocType
     */
    public function destroy($cdt)
    {
        $cdt = ClientDocType::findOrFail( $cdt );
        $cdt->delete();
        return $this->successResponse( $cdt );
    }
}
