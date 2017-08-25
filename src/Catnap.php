<?php

namespace Catnap;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class Catnap extends Controller
{

	protected $model = null;
	protected $form_request = null;

	public function __construct()
	{
		$this->model = new $this->model();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$validation = (new Validation)->validate(request(), $this->form_request);

		if( is_a($validation, JsonResponse::class) ) {
			return $validation;
		}

		return $this->model->paginate();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function store(Request $request)
	{
		$validation = (new Validation)->validate($request, $this->form_request);

		if( is_a($validation, JsonResponse::class) ) {
			return $validation;
		}

		return $this->model->create($request->all());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$validation = (new Validation)->validate(request(), $this->form_request);

		if( is_a($validation, JsonResponse::class) ) {
			return $validation;
		}

		$record = $this->model->find($id);

		if ( ! $record ) {
			return response()->json(['status' => 'NOT_FOUND'], 404);
		}

		return $record;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{

		$validation = (new Validation)->validate($request, $this->form_request);

		if( is_a($validation, JsonResponse::class) ) {
			return $validation;
		}

		$record = $this->model->find($id);

		if(! $record) {
			return response()->json(['status' => 'NOT FOUND'], 404);
		}

		return $record->update($request->all())
			? response()->json(['status' => 'OK'])
			: response()->json(['status' => 'FAIL']);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{

		$validation = (new Validation)->validate(request(), $this->form_request);

		if( is_a($validation, JsonResponse::class) ) {
			return $validation;
		}

		$record = $this->model->find($id);

		if ( ! $record ) {
			return response()->json(['status' => 'NOT FOUND'], 404);
		}

		return $record->delete()
			? response()->json(['status' => 'OK'])
			: response()->json(['status' => 'FAIL']);
	}

}