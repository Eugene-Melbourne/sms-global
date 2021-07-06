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
     * It displays a Swagger OpenAPI documentation of the `/api` endpoints
     */
    public function get_docs(Request $request): View
    {
        return view('open-api.index');
    }


    /**
     * It displays a Swagger OpenAPI YAML for `/api` endpoints
     */
    public function get_yaml(Request $request): string
    {
        $paths = [
            base_path('app/Http/Controllers/Api'),
            base_path('app/virtual'),
        ];

        $openApi = Generator::scan($paths);

        return $openApi->toYaml();
    }


}
