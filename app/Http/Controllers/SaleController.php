<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\ApiResponser;
use App\Models\Order;
use App\Models\Client;
use App\Models\OrderDocType;
use App\Models\OrdersDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\ClientController;

class SaleController extends Controller
{
    use ApiResponser;

    public function generate_order_document_number($doc_type)
    {
        $doc_number = '';
        $doc_number_amount = OrderDocType::findOrFail( $doc_type )["digit_amount"];

        for($i = 0; $i < $doc_number_amount; $i++)
            $doc_number .= random_int(0,9);
        
        return $doc_number;
    }

    public function generate(Request $request)
    {
        // Check input information
        $rules = [
            // Check Client Information
            "client" => 'required|array',
            "client.doc_type" => 'required|integer|exists:client_doc_types,id',
            "client.doc_number" => 'required|string|min:8|max:20',
            "client.first_name" => 'required|string|max:50',
            "client.last_name" => 'required|string|max:50',
            "client.phone" => 'required|string|max:20',
            "client.email" => 'required|string|max:50',
            
            // Check Order Information
            "order" => 'required|array',
            "order.total" => 'required|numeric|min:0',
            "order.doc_type" => 'required|integer|exists:order_doc_types,id',

            // Check Order Detail Information
            "products" => 'nullable|array',
            "products.*.book_id" => 'required|integer|exists:books,id',
            "products.*.detail_price" => 'required|numeric|min:0.1',
            "products.*.quantity" => 'required|integer|min:1'
        ];

        $this->validate( $request, $rules );

        // Create Client Object
        $client = Client::create($request->get("client"));

        // Create Order Object
        $order_data = $request->get("order");
        $order_doc_number = $this->generate_order_document_number($order_data["doc_type"]);
        $order_data["doc_number"] = $order_doc_number;
        $order_data["client_id"] = $client["id"];
        $order = Order::create($order_data);

        // Check availability of Order Details Objects
        foreach( $request->get("products") as $order_detail_data )
        {
            // Decrease Book Quantity
            $book = Book::find( $order_detail_data["book_id"] );
            $newStock = $book["stock"] - $order_detail_data["quantity"];
            if( $newStock > 0 )
            {
                $book->update(["stock"=>$newStock]);
                $order_detail_data["order_id"] = $order["id"];
                OrdersDetail::create($order_detail_data);
            }
            else
                throw new \Exception("ISBN: $book->isbn -> no tiene suficiente stock");
        }

        return $this->successResponse( true );
    }
}
