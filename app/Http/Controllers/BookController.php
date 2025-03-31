<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    use ApiResponser;
    
    public function generate_isbn()
    {
        $isbn = '';
        for($i = 0; $i < 13; $i++)
            $isbn .= random_int(0,9);
        
        return $isbn;
    }

    public function index()
    {
        $books = Book::all();

        return $this->successResponse($books);
    }

    public function store(Request $request)
    {
        $request->merge(["isbn" => $this->generate_isbn()]);

        $rules = [
            "isbn" => [ 'required' , 'string' , 'min:13' , 'max:13' , Rule::unique('books','isbn')],
            "name" => [ 'required' , 'string' , 'max:20' ],
            "stock" => [ 'required' , 'integer' , 'min:1' ],
            "book_price" => [ 'required' , 'numeric' , 'min:0.1' ]
        ];

        $this->validate( $request , $rules );

        $book = Book::create( $request->all() );

        return $this->successResponse($book);
    }

    public function show($isbn_or_name)
    {
        $found = Book::where("isbn",$isbn_or_name)->first();
        if( !$found )
            $found = Book::where("name",$isbn_or_name)->firstOrFail();
        return response()->json(["data"=>$found],Response::HTTP_OK);
    }

    public function update(Request $request, $isbn)
    {
        $rules = [
            "name" => [ 'required' , 'string' , 'max:20' ],
            "stock" => [ 'required' , 'integer' , 'min:1' ],
            "book_price" => [ 'required' , 'numeric' , 'min:0.1' ]
        ];

        $this->validate( $request , $rules );

        $book = Book::where("isbn",$isbn)->firstOrFail();

        $book->fill( $request->all() );

        if( $book->isClean() )
            return $this->errorResponse("Al menos un valor debe ser cambiado",Response::HTTP_UNPROCESSABLE_ENTITY);

        $book->save();

        return $this->successResponse($book);
    }

    public function destroy($isbn)
    {
        $book = Book::where("isbn",$isbn)->firstOrFail();

        $book->delete();

        return $this->successResponse($book);
    }
}
