<?php

namespace App\Http\Controllers;

use App\ApiResponser;
use App\Models\OrderDocType;
use Illuminate\Http\Request;

class OrderDocTypeController extends Controller
{
    use ApiResponser;

    /**
     * Get all Client Document Types
     * 
     * @return Array[OrderDocType]
     */
    public function index()
    {
        $OrderDocType = OrderDocType::all();
        return $this->successResponse( $OrderDocType );
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
            "name" => 'required|string',
            "digit_amount" => 'required|integer|min:1'
        ];

        $this->validate( $request , $rules );

        $odt = OrderDocType::create( $request->all() );

        return $this->successResponse( $odt );
    }

    /**
     * Get one Client Document Type
     * @param String
     * 
     * @return ClientDocType || Null
     */
    public function show($odt)
    {
        $odt = OrderDocType::findOrFail($odt);
        return $this->successResponse( $odt );
    }

    /**
     * Update one Client Document Type
     * @param Request
     * @param String
     * 
     * @return ClientDocType
     */
    public function update(Request $request , $odt)
    {
        $rules = ["name"=>"required|string"];
        $this->validate( $request , $rules );

        $odt = OrderDocType::findOrFail( $odt );

        $odt->fill( $request->all() );

        if( $odt->isClean() )
            return $this->errorResponse( "Al menos un valor debe ser cambiado" , Response::HTTP_UNPROCESSABLE_ENTITY );

        $odt->save();

        return $this->successResponse( $odt );
    }

    /**
     * Destroy one Client Document Types
     * @param String
     * 
     * @return ClientDocType
     */
    public function destroy($odt)
    {
        $odt = OrderDocType::findOrFail( $odt );
        $odt->delete();
        return $this->successResponse( $odt );
    }
}
