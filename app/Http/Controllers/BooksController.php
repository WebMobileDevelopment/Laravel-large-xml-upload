<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Jobs\XmlProcess;
use App\Models\Books;

class BooksController extends Controller
{

	/**
	 * Initializer.
	 *
	 * @access   public
	 * @return \BooksController
	 */
	public function __construct()
	{
		// $this->beforeFilter('csrf', array('on' => 'post'));
	}


	public function index(Request $request)
	{
		$search =  $request->input('search');
        if($search!=""){
            $books = Books::where(function ($query) use ($search){
                $query->where('Title', 'like', '%'.$search.'%')
                    ->orWhere('ISBN', 'like', '%'.$search.'%');
            })
            ->paginate(100);
            $books->appends(['search' => $search]);
        }
        else{
            $books = Books::paginate(100);
		}
    	return response()->json($books);
	}


	public function upload(Request $request)
	{

		$books= $request->get('params');
		XmlProcess::dispatch($books);
		$message = array(
			'type' => 'success',
			'text' => 'Your file has been uploaded! You will receive an email when processing is complete!',
			'title' => 'Success',
		);
		session()->flash('message', $message);
		return  response()->json([
			'success' => true
		]);
	}
}
