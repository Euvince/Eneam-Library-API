<?php

namespace App\Http\Controllers\API\SupportedMemory;

use App\Models\SupportedMemory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SupportedMemory\SupportedMemoryResource;
use App\Responses\SupportedMemory\SingleSupportedMemoryResponse;
use App\Http\Requests\SupportedMemory\DepositSupportedMemoryRequest;

class DepositSupportedMemoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(DepositSupportedMemoryRequest $request)
    {
        dd($request);
        $supportedMemory = SupportedMemory::create($this->withDocuments(new SupportedMemory(), $request));
        return new SingleSupportedMemoryResponse(
            statusCode : 201,
            allowValue : 'POST',
            message : "Votre mémoire a été soumis avec succès",
            resource : new SupportedMemoryResource(resource : $supportedMemory)
        );
    }

    private function withDocuments(SupportedMemory $supportedMemory, DepositSupportedMemoryRequest $request): array
    {
        $data = $request->validated();
        if(array_key_exists('file_path', $data))
        {
            $memoryCollection = $data['document'];
            $data['document'] = $documentCollection->storeAs('documents', $request->file('document')->getClientOriginalName(), 'public');
            $documentpath = 'public/' . $document->document;
            if(Storage::exists($documentpath)) Storage::delete('public/' . $document->document);
        }
        return $data;
    }

}
