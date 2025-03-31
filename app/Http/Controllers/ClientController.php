<?php

namespace App\Http\Controllers;

use App\ApiResponser;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\ClientDocType;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    use ApiResponser;

    protected function document_validation(Request $request)
    {
        $type = $request->get('doc_type');
        $doc_type = ClientDocType::findOrFail( $type );
        if( $doc_type["digit_amount"] !== strlen( $request->get('doc_number') ) )
            throw new \Exception("El documento proporcionado es inválido.");
        return;
    }

    /**
     * Get all Client Document Types
     * 
     * @return Array[Client]
     */
    public function index()
    {
        $Client = Client::with("doc_type:id,name")->get();
        return $this->successResponse( $Client );
    }

    /**
     * Create a Client Document Type
     * @param Request
     * 
     * @return Client
     */
    public function store(Request $request)
    {
        $rules = [
            "doc_type" => 'required|integer|exists:client_doc_types,id',
            "doc_number" => 'required|string|min:8|max:20',
            "first_name" => 'required|string|max:50',
            "last_name" => 'required|string|max:50',
            "phone" => 'required|string|max:20',
            "email" => 'required|string|max:50'
        ];

        $this->validate( $request , $rules );

        $this->document_validation($request);

        $client = Client::create( $request->all() );

        return $this->successResponse( $client );
    }

    /**
     * Get one Client Document Type
     * @param String
     * 
     * @return Client || Null
     */
    public function show($client)
    {
        $client = Client::with("doc_type")->findOrFail( $client );
        return $this->successResponse( $client );
    }

    /**
     * Update one Client Document Type
     * @param Request
     * @param String
     * 
     * @return Client
     */
    public function update(Request $request , $client)
    {
        $rules = [
            "doc_type" => 'required|integer|exists:client_doc_types,id',
            "doc_number" => 'required|string|min:8|max:20',
            "first_name" => 'required|string|max:50',
            "last_name" => 'required|string|max:50',
            "phone" => 'required|string|max:20',
            "email" => 'required|string|max:50'
        ];
        $this->validate( $request , $rules );

        $this->document_validation($request);

        $client = Client::with("doc_type")->findOrFail( $client );

        $client->fill( $request->all() );

        if( $client->isClean() )
            return $this->errorResponse( "Al menos un valor debe ser cambiado" , Response::HTTP_UNPROCESSABLE_ENTITY );

        $client->save();

        return $this->successResponse( $client );
    }

    /**
     * Destroy one Client Document Types
     * @param String
     * 
     * @return Client
     */
    public function destroy($client)
    {
        $client = Client::findOrFail( $client );
        $client->delete();
        return $this->successResponse(true);
    }
}
