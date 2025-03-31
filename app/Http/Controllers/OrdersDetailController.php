<?php

namespace App\Http\Controllers;

use App\Models\Book;
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

    protected function verify_book_stock(Request $request)
    {
        $book = Book::findOrFail( $request->get('book_id') );
        $newStock = $book["stock"] - $request->get("quantity");
        if( $newStock < 0 )
            return true;
        $book->update(["stock" => $newStock]);
        return;
    }

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

        if( $this->verify_book_stock($request) )
            return $this->errorResponse("El libro especificado no tiene suficiente stock",Response::HTTP_UNPROCESSABLE_ENTITY);

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

        if( $this->verify_book_stock($request) )
            return $this->errorResponse("El libro especificado no tiene suficiente stock",Response::HTTP_NOT_MODIFIED);

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
