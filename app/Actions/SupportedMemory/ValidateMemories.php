<?php

namespace App\Actions\SupportedMemory;

use App\Models\SupportedMemory;
use App\Jobs\GenerateFilingReportJob;
use App\Jobs\ValidateSupportedMemoryJob;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Requests\SupportedMemory\SupportedMemoryRequest;

class ValidateMemories
{

    public static function validateMemory (SupportedMemory $supportedMemory) : JsonResponse
    {
        if (SupportedMemory::isValide($supportedMemory)) {
            return response()->json(
                status : 403,
                headers : ["Allow" => 'GET, POST, PATCH, DELETE'],
                data : ['message' => "Le mémoire soutenu a déjà été validé"],
            );
        }
        else {
            $validMemoriesInCurrentYearNumber = SupportedMemory::query()
            ->where('status', 'Validé')
            ->whereHas('soutenance', function (Builder $query) use ($supportedMemory) {
                $query->where('school_year_id', $supportedMemory->soutenance->school_year_id);
            })->count();

            $supportedMemory->update([
                'status' => "Validé",
                'cote'   => \Carbon\Carbon::parse($supportedMemory->soutenance->start_date)->year."/".$supportedMemory->sector->acronym."/".$validMemoriesInCurrentYearNumber + 1
            ]);
            \App\Models\Soutenance::find(
                $supportedMemory->soutenance->id
            )->update([
                'number_memories_remaining' => --$supportedMemory->soutenance->number_memories_remaining
            ]);
            /* GenerateFilingReportJob::dispatch($supportedMemory); */
            ValidateSupportedMemoryJob::dispatch($supportedMemory);
            return response()->json(
                status : 200,
                headers : ["Allow" => 'GET, POST, PATCH, DELETE'],
                data : ['message' => "Le mémoire soutenu a été validé avec succès"],
            );
        }
    }

    public static function validateMemories (SupportedMemoryRequest $request) : JsonResponse
    {
        $ids = $request->validated('ids');

        $validMemories = SupportedMemory::whereIn('id', $ids)
            ->where('status', "Validé")
            ->count();

        if ($validMemories > 0) {
            return response()->json(
                status : 200,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "Certains mémoires envoyés sont déjà validés"],
            );
        }
        else {
            array_map(function (int $id) {
                $supportedMemory = SupportedMemory::find($id);
                $validMemoriesInCurrentYearNumber = SupportedMemory::query()
                ->where('status', 'Validé')
                ->whereHas('soutenance', function (Builder $query) use ($supportedMemory) {
                    $query->where('school_year_id', $supportedMemory->soutenance->school_year_id);
                })->count();

                $supportedMemory->update([
                    'status' => "Validé",
                    'cote'   => \Carbon\Carbon::parse($supportedMemory->soutenance->start_date)->year."/".$supportedMemory->sector->acronym."/".$validMemoriesInCurrentYearNumber + 1
                ]);
                \App\Models\Soutenance::find(
                    $supportedMemory->soutenance->id
                )->update([
                    'number_memories_remaining' => --$supportedMemory->soutenance->number_memories_remaining
                ]);

                ValidateSupportedMemoryJob::dispatch($supportedMemory);

            }, $ids);
            return response()->json(
                status : 200,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : [
                    'message' => count($ids) > 1
                        ? "Les mémoires soutenus ont été validés avec succès"
                        : "Le mémoire soutenu a été validé avec succès"
                ],
            );
        }
    }


}
