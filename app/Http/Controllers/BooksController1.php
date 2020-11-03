<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Jobs\XmlProcess;
use App\Models\Books;

class BooksController1  extends Controller
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



	public function upload(Request $request)
	{

		if ($request->file('import_file')) {
			$rules = array(
				'import_file' => 'required|mimes:xml',
			);
			$validator =  Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				$errors['import_file'] = 'This is not a .xml file!';
				return redirect()->back()->withInput()->withErrors($errors);
			} else {
				$path = $request->file('import_file')->getRealPath();
				// $path = "C:\\xampp\\tmp\\test.xml";
				XmlProcess::dispatch($path);
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
		} else {
			return response()->json(['error' => "There isn't xml file"]);
		}
	}
}
