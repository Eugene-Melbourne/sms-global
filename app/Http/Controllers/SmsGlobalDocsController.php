<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use OpenApi\Generator;
use function base_path;
use function view;

class SmsGlobalDocsController extends Controller
{


    /**
     * It displays a Swagger OpenAPI documentation of the `/api` endpoints. 
     */
    public function get_docs(Request $request): View
    {
        return view('open-api.index');
    }


    public function get_yaml(Request $request): string
    {

        $openapi = Generator::scan([base_path('app')]);

        return $openapi->toYaml();
    }


}
