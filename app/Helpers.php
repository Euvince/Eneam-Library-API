<?php

namespace App;

class Helpers
{
    public static function mb_ucfirst (string $string, string $encoding = "UTF-8") {
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
    }

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
