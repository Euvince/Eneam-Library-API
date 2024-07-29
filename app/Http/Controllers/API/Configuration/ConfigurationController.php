<?php

namespace App\Http\Controllers\API\Configuration;

use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigurationRequest;
use App\Http\Resources\Configuration\ConfigurationResource;
use App\Http\Responses\Configuration\SingleConfigurationResponse;

class ConfigurationController extends Controller
{
    public function __invoke(Request $request) : SingleConfigurationResponse
    {
        /*  dd(\App\Models\Configuration::first()->getAttributes()); */
        /*  $this->authorize('viewAny', Configuration::class); */
        return new SingleConfigurationResponse(
            statusCode : 200, allowedMethods : 'PATCH', message : "Configuration de l'année en cours",
            resource : new ConfigurationResource(resource : Configuration::appConfig())
        );
    }
}
