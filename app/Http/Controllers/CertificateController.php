<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use TCPDF;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    protected $title = 'Certificate';

    public function index()
    {
        $title = $this->title;
        $certificates = Certificate::all();
        return view('pages.certificates.index', compact('title', 'certificates'));
    }

    public function create()
    {
        $title = $this->title;
        $users = User::all();
        $events = Event::all();
    
        return view('pages.certificates.create', compact('title', 'users', 'events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
        ]);

        Certificate::create($request->all());

        return redirect()->route('certificates.index')->with('success', 'Certificate created successfully.');
    }

    public function edit(Certificate $certificate)
    {
        $title = $this->title;
        $users = User::all();
        $events = Event::all();

        return view('pages.certificates.edit', compact('title', 'certificate', 'users', 'events'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
        ]);

        $certificate->update($request->all());

        return redirect()->route('certificates.index')->with('success', 'Certificate updated successfully.');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        
        return redirect()->route('certificates.index')->with('success', 'Certificate deleted successfully.');
    }
    
    public function generate($userId)
    {
        $backgroundPath = public_path(Storage::url('assets/sample-bg-cert-1.jpg'));
        $logoPath = public_path(Storage::url('assets/logo-gojek.png'));
        $signaturePath = public_path(Storage::url('assets/sample-signature-3.png'));
        
        // Create new TCPDF instance
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator('MFI');
        $pdf->SetAuthor('MFI');
        $pdf->SetTitle('Certificate');
        $pdf->SetSubject('Certificate');
        
        // Set default font
        $pdf->SetFont('helvetica', '', 12);
        
        // Add a page
        $pdf->AddPage();

        // vars
        $bMargin = $pdf->getBreakMargin();
        $auto_page_break = $pdf->getAutoPageBreak();
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->Image($backgroundPath, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
        $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
        $pdf->setPageMark();
        
        // Set company logo
        $pdf->Image($logoPath, 135, 20, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0);

        // Set certificate title
        $pdf->SetFont('helvetica', 'B', 24);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(20, 70);
        $pdf->Cell(0, 0, 'SERTIFIKAT', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        
        // Set certificate number
        $pdf->SetFont('helvetica', 'R', 14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(20, 77);
        $pdf->Cell(0, 0, 'Nomor: 1023/1/JPL1110/2023', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // Set a/n
        $pdf->SetFont('helvetica', 'R', 14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(20, 92);
        $pdf->Cell(0, 0, 'diberikan kepada', 0, false, 'C', 0, '', 0, false, 'M', 'M');
       
        // Set participant name
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(20, 100);
        $pdf->Cell(0, 0, 'Muhammad Fadhal Ikram', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // Line
        $pdf->SetLineWidth(0.7);
        $pdf->Line(85, 105, 220, 105);

        // Set seminar details
        $pdf->SetFont('helvetica', 'R', 16);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(50, 115);
        $pdf->MultiCell(200, 0, 'Sebagai Peserta dalam kegiatan seminar "Pengenalan Industri 4.0 pada Milenial pada Era Digital dan Teknologi Terbaru" yang dilaksanakan pada Tanggal 17 Oktober 2022 bertempat di Digital Library Unimed.', 0, 'C');
        
        // Set speaker name
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(20, 150);
        $pdf->Cell(0, 0, 'CEO OF PT. Gojek', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // Set signature
        $pdf->Image($signaturePath, 130, 155, 50, '', 'PNG', '', 'T', false, 300, '', false, false, 0);
        
        // Set organizer name
        $orgX = 20;
        $orgY = 183;
        $orgName = "Saiful Jamillah Yaa";
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY($orgX, $orgY);
        $pdf->Cell(0, 0, $orgName, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $lineLength = $pdf->GetStringWidth($orgName);
        // $pdf->SetLineWidth(0.7);
        // $pdf->Line(($pdfWidth / 2) - ($lineLength / 2), $orgY + 3, ($pdfWidth / 2) + $lineLength - 12, $orgY + 3);

        // Output the PDF
        $pdf->Output('certificate.pdf', 'I');
        // $pdfPath = storage_path('app/public/certificates/certificate.pdf');
        // $pdf->Output($pdfPath, 'F');

        // Clean up temporary files
        // unlink($tempLogoPath);
        // unlink($tempSignaturePath);

    }
}
