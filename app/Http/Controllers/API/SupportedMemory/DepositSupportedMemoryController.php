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
    public function __invoke(DepositSupportedMemoryRequest $request) : SingleSupportedMemoryResponse
    {
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
        if(array_key_exists('file_path', $data) &&  array_key_exists('cover_page_path', $data))
        {
            $memoryCollection = $data['file_path'];
            $coverPageCollection = $data['cover_page_path'];
            $data['file_path'] = $memoryCollection->storeAs('Memories', $request->file('file_path')->getClientOriginalName(), 'public');
            $data['cover_page_path'] = $coverPageCollection->storeAs('Cover pages', $request->file('cover_page_path')->getClientOriginalName(), 'public');
            $memorypath = 'public/' . $supportedMemory->file_path;
            $coverPagePath = 'public/' . $supportedMemory->cover_page_path;
            if(Storage::exists($memorypath)) Storage::delete($memorypath);
            if(Storage::exists($coverPagePath)) Storage::delete($coverPagePath);
        }
        return $data;
    }

}
