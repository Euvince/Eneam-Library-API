<?php

namespace App\Actions\SupportedMemory;

class DepositAction
{
    /* private function withDocuments(SupportedMemory $supportedMemory, DepositSupportedMemoryRequest $request): array
    {
        $data = $request->validated();
        $data['motclefs'] = '#' . implode('#', $request->validated('motclefs'));
        unset($data['fonctions']);
        if(array_key_exists('document', $data))
        {
            $documentCollection = $data['document'];
            $data['document'] = $documentCollection->storeAs('documents', $request->file('document')->getClientOriginalName(), 'public');
            $documentpath = 'public/' . $document->document;
            if(Storage::exists($documentpath)) Storage::delete('public/' . $document->document);
        }
        return $data;
    } */
}
