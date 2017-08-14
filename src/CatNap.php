<?php

namespace AbiCRM\CatNap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CatNap extends Controller
{

	protected $model = null;

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
		return $this->model->paginate();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
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
		$record = $this->model->find($id);

		if ( ! $record ) {
			return response()->json(['status' => 'NOT FOUND'], 404);
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
		$record = $this->model->find($id);

		if ( ! $record ) {
			return response()->json(['status' => 'NOT FOUND'], 404);
		}

		return $record->delete()
			? response()->json(['status' => 'OK'])
			: response()->json(['status' => 'FAIL']);
	}

}