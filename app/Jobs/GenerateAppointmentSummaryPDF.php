<?php

namespace App\Jobs;

use App\Models\ClinicalNotes;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateAppointmentSummaryPDF implements ShouldQueue
{
    use Queueable ,InteractsWithQueue, SerializesModels;
    private $summaryJson;
    private $patientId;
    private $professionalId;
    private $clinicalNoteId;
    /**
     * Create a new job instance.
     */
    public function __construct($clinicalNoteId , $summaryJson , $patientId , $professionalId)
    {
        $this->clinicalNoteId = $clinicalNoteId;
        $this->summaryJson = $summaryJson;
        $this->patientId = $patientId;
        $this->professionalId = $professionalId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pdfs_list = array();
        $professionDetail = User::whereHas("roles", function($q){ $q->where("name", "medical"); })->with('professionalDetails')->where('id', $this->professionalId)->first();
        $patientDetail = User::with('medicalDetails')->where('id', $this->patientId)->first();
        foreach ($this->summaryJson as $key => $value) {
            $weight = isset($patientDetail->medicalDetails->weight) ? $patientDetail->medicalDetails->weight . ' kg' : 'N/A';
            $registrationNumber = $professionDetail->professionalDetails->regestraion_number ?? 'N/A';

            if ($registrationNumber !== 'N/A') {
                $maskedRegistrationNumber = '****' . substr($registrationNumber, -2);
            } else {
                $maskedRegistrationNumber = 'N/A';
            }

            if ($key === 'Prescription' || $key === 'prescription') {
                $background = public_path('pdfs/background.png');
            }
            else{
                $background = public_path('pdfs/background2.png');
            }
            $data = [
                'background' => $background,
                'date' => date('d/m/Y'),
                'patient_id' => $patientDetail['id'] ?? 'N/A',
                'patient_name' => $patientDetail['first_name'] . ' ' . $patientDetail['last_name'],
                'patient_address' => $patientDetail['city'] . ', ' . $patientDetail['state'] . ', ' . $patientDetail['country'],
                'patient_phone' => $patientDetail['contact'] ?? 'N/A',
                'patient_age' => isset($patientDetail['dob']) ? date_diff(date_create($patientDetail['dob']), date_create('today'))->y . ' years' : 'N/A',
                'patient_weight' => $weight,
                'patient_gender' => $patientDetail['gender'] ?? '',
                'doctor_name' => $professionDetail['first_name'] . ' ' . $professionDetail['last_name'],
                'doctor_license' => $maskedRegistrationNumber,
                'doctor_signature' => $professionDetail->professionalDetails->signature ?? 'N/A',
                'note_key' => $key,
                'note_value' => $value,
            ];
            if ($key === 'Prescription' || $key === 'prescription') {
                $prefix = 'prescription_';
                $pdf = Pdf::loadView('pdf.prescription', $data)->setPaper('legal', 'portrait');
            } else {
                $prefix = 'none_prescription_';
                $pdf = Pdf::loadView('pdf.consultation_summary', $data)->setPaper('legal', 'portrait');
            }

            $relative_path = 'prescriptions/' . $prefix . time() . '_' . uniqid() . '.pdf';
            Storage::disk('public')->put($relative_path, $pdf->output());
            $public_url = Storage::disk('public')->url($relative_path);
            $pdfs_list[$key] = $public_url;
        }
        $clinicalNote = ClinicalNotes::find($this->clinicalNoteId);
        $clinicalNote->update([
            'pdfs_list' => json_encode($pdfs_list)
        ]);
    }
}
