<?php

namespace App\Http\Controllers;

use App\ApiResponser;
use App\Models\Order;
use App\Models\OrderDocType;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponser;

    /**
     * Generate Document Number depending on Document Type
     * 
     * @param Integer:OrderDocType
     * 
     * @return String: 12 || 20
     */
    public function generate_doc_number($doc_type)
    {
        $doc_number = '';
        $doc_number_amount = OrderDocType::findOrFail( $doc_type )["digit_amount"];

        for($i = 0; $i < $doc_number_amount; $i++)
            $doc_number .= random_int(0,9);
        
        return $doc_number;
    }

    /**
     * Get all Order Document Types
     * 
     * @return Array[Order]
     */
    public function index()
    {
        $order = Order::all();
        return $this->successResponse( $order );
    }

    /**
     * Create a Order Document Type
     * @param Request
     * 
     * @return Order
     */
    public function store(Request $request)
    {
        $rules = [
            "client_id" => 'required|integer|exists:clients,id',
            "total" => 'required|numeric',
            "doc_type" => 'required|integer|exists:order_doc_types,id'
        ];

        $this->validate( $request , $rules );

        $doc_number = $this->generate_doc_number( $request->get("doc_type") );

        $request->merge([ "doc_number" => $doc_number ]);

        $order = Order::create( $request->all() );

        return $this->successResponse( $order );
    }

    /**
     * Get one Order Document Type
     * @param String
     * 
     * @return Order || Null
     */
    public function show($order)
    {
        $order = Order::findOrFail( $order );
        return $this->successResponse( $order );
    }

    /**
     * Update one Order Document Type
     * @param Request
     * @param String
     * 
     * @return Order
     */
    public function update(Request $request , $order)
    {
        $rules = [
            "client_id" => 'required|integer|exists:clients,id',
            "total" => 'required|numeric',
            "doc_type" => 'required|integer|exists:order_doc_types,id'
        ];
        $this->validate( $request , $rules );

        $order = Order::findOrFail( $order );

        $order->fill( $request->all() );

        if( $order->isClean() )
            return $this->errorResponse( "Al menos un valor debe ser cambiado" , Response::HTTP_UNPROCESSABLE_ENTITY );

        $order->save();

        return $this->successResponse( $order );
    }

    /**
     * Destroy one Order Document Types
     * @param String
     * 
     * @return Order
     */
    public function destroy($order)
    {
        $order = Order::findOrFail( $order );
        $order->delete();
        return $this->successResponse( $order );
    }
}
