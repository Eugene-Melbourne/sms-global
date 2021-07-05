<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Generator;

class SmsGlobalDocsController extends Controller
{


    /**
     * It displays a Swagger OpenAPI documentation of the `/api` endpoints. 
     */
    public function get_docs(Request $request): string
    {

        $openapi = Generator::scan([base_path('app')]);

        return $openapi->toYaml();
    }


}
