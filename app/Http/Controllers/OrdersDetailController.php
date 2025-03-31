<?php

namespace App\Http\Controllers;

use App\ApiResponser;
use App\Models\OrdersDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrdersDetailController extends Controller
{
    use ApiResponser;

    protected $with = [
        "order_id",
        "order_id.client_id",
        "order_id.doc_type",
        "order_id.client_id.doc_type",
        "book_id"
    ];

    /**
     * Get all Order Details
     * 
     * @return Array[OrdersDetail]
     */
    public function index()
    {
        
        $OrdersDetail = OrdersDetail::with($this->with)->get();
        return $this->successResponse( $OrdersDetail );
    }

    /**
     * Create a Order Detail
     * @param Request
     * 
     * @return Order Detail
     */
    public function store(Request $request)
    {
        $rules = [
            "order_id" => 'required|integer|exists:orders,id',
            "book_id" => 'required|integer|exists:books,id',
            "detail_price" => 'required|numeric|min:0.1',
            "quantity" => 'required|integer|min:1'
        ];

        $this->validate( $request , $rules );

        $OrdersDetail = OrdersDetail::create( $request->all() );

        return $this->successResponse( $OrdersDetail );
    }

    /**
     * Get one Order Detail
     * @param String
     * 
     * @return OrdersDetail || Null
     */
    public function show($detail_id)
    {
        $OrdersDetail = OrdersDetail::with($this->with)->findOrFail($detail_id);
        return $this->successResponse( $OrdersDetail );
    }

    /**
     * Update one Order Detail
     * @param Request
     * @param String
     * 
     * @return OrdersDetail
     */
    public function update(Request $request , $detail)
    {
        $rules = [
            "order_id" => 'required|integer|exists:orders,id',
            "book_id" => 'required|integer|exists:books,id',
            "details_price" => 'required|numeric|min:0.1',
            "quantity" => 'required|integer|min:1'
        ];
        $this->validate( $request , $rules );

        $OrdersDetail = OrdersDetail::findOrFail( $detail );

        $OrdersDetail->fill( $request->all() );

        if( $OrdersDetail->isClean() )
            return $this->errorResponse( "Al menos un valor debe ser cambiado" , Response::HTTP_UNPROCESSABLE_ENTITY );

        $OrdersDetail->save();

        return $this->successResponse( $OrdersDetail );
    }

    /**
     * Destroy one Client Document Types
     * @param String
     * 
     * @return Client
     */
    public function destroy( $detail )
    {
        $OrdersDetail = OrdersDetail::findOrFail( $detail );
        $OrdersDetail->delete();
        return $this->successResponse( $OrdersDetail );
    }
}
