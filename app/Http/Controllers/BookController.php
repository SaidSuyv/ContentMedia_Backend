<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
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

        return response()->json(["data"=>$books],Response::HTTP_OK);
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

        $data = $request->validate( $rules );

        $book = Book::create( $data );

        return response()->json(["data"=>$book],Response::HTTP_OK);
    }

    public function show($book)
    {
        $found = Book::where("isbn",$book)->first(); 
        return response()->json(["data"=>$found],Response::HTTP_OK);
    }

    public function update(Request $request,$book)
    {
        $rules = [
            "name" => [ 'required' , 'string' , 'max:20' ],
            "stock" => [ 'required' , 'integer' , 'min:1' ],
            "book_price" => [ 'required' , 'numeric' , 'min:0.1' ]
        ];

        $fields = $request->validate( $rules );

        $book = Book::where( "isbn" , $book )->first();
        return response()->json(['data'=>$book],Response::HTTP_OK);

        // if( $book != null )
        // return response()->json(["data"=>"NIGGA WHAT? R U SERIOUS?"],Response::HTTP_UNPROCESSABLE_ENTITY);

        // $book->fill( $book );

        // if( $book->isClean() )
        //     return response()->json(["data"=>"NIGGA WHAT? R U SERIOUS?"],Response::HTTP_UNPROCESSABLE_ENTITY);

        // $book->save();

        // return response()->json(['data'=>$book],Response::HTTP_OK);
    }
}
