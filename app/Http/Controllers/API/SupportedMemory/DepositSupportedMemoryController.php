<?php

namespace App\Http\Controllers\API\SupportedMemory;

use App\Actions\SupportedMemory\SMHelper;
use App\Models\SupportedMemory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SupportedMemory\SupportedMemoryResource;
use App\Http\Responses\SupportedMemory\SingleSupportedMemoryResponse;
use App\Http\Requests\SupportedMemory\DepositSupportedMemoryRequest;
use Illuminate\Http\UploadedFile;

class DepositSupportedMemoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(DepositSupportedMemoryRequest $request) : SingleSupportedMemoryResponse
    {
        /* $this->authorize('create', SupportedMemory::class); */
        $supportedMemory = SupportedMemory::create(SMHelper::helper(new SupportedMemory(), $request));
        return new SingleSupportedMemoryResponse(
            statusCode : 201,
            allowedMethods : 'GET, POST, DELETE',
            message : "Votre mémoire a été soumis avec succès",
            resource : new SupportedMemoryResource(resource : SupportedMemory::query()->with(['sector.sector', 'soutenance.cycle', 'soutenance.schoolYear'])->where('id', $supportedMemory->id)->first())
        );
    }

    private function addFiles(SupportedMemory $supportedMemory, DepositSupportedMemoryRequest $request): array
    {
        $data = $request->validated();
        if(array_key_exists('file_path', $data) &&  array_key_exists('cover_page_path', $data))
        {
            /** @var UploadedFile|null $memoryCollection */
            $memoryCollection = $data['file_path'];
            /** @var UploadedFile|null $coverPageCollection */
            $coverPageCollection = $data['cover_page_path'];
            $data['file_path'] = $memoryCollection->storeAs('SupportedMemories/memories', $request->file('file_path')->getClientOriginalName(), 'public');
            $data['cover_page_path'] = $coverPageCollection->storeAs('SupportedMemories/Cover pages', $request->file('cover_page_path')->getClientOriginalName(), 'public');
            $memorypath = 'public/' . $supportedMemory->file_path;
            $coverPagePath = 'public/' . $supportedMemory->cover_page_path;
            if(Storage::exists($memorypath)) Storage::delete($memorypath);
            if(Storage::exists($coverPagePath)) Storage::delete($coverPagePath);
        }
        return $data;
    }

}
