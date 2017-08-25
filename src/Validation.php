<?php

namespace Catnap;

use Validator;
use Illuminate\Http\Request;

class Validation
{
	public function validate(Request $request, $form_request)
	{
		if ( is_subclass_of($form_request, "Illuminate\Foundation\Http\FormRequest") ) {

			if ( method_exists($form_request, "authorize") && !$form_request->authorize() ) {
				return response()->json([
					'status' => 'Unauthorized',
				], 403);
			}

			if ( method_exists($form_request, "rules") ) {
				$validator = Validator::make($request->all(), $form_request->rules());

				if ($validator->fails()) {
					return response()->json(
						[
							'status' => 'validation',
							'data' => $validator->errors()
						],
						422
					);
				}

			}

		}

		return true;

	}
}