<?php

namespace App\Jobs;

use App\Models\SupportedMemory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class GenerateFilingReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly SupportedMemory $supportedMemory
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $pdf = FacadePdf::loadView(view : 'fiche', data : [
            'memory' => $this->supportedMemory,
            'config' => \App\Models\Configuration::appConfig(),
        ])
        ->setOptions(['defaultFont' => 'sans-serif'])
        ->setPaper('A4', 'portrait');
        return $pdf->download('fiche.pdf');
    }
}
