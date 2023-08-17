<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Registration;
use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use TCPDF;
use Carbon\Carbon;

class EventController extends Controller
{
    protected $title = 'Event';

    public function index()
    {
        $title = $this->title;
        $events = Event::with('certificate')->get();
       
        foreach ($events as $event) {
            $event->banner_image_url = Storage::url($event->banner_image);
            $event->banner_slider_image_url = $event->banner_slider_image ? Storage::url($event->banner_slider_image) : null;
        }
        
        return view('pages.events.index', compact('title', 'events'));
    }

    public function create()
    {
        $title = $this->title;
        $categories = Category::all();
    
        return view('pages.events.create', compact('title', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'description' => 'nullable',
            'title' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'banner_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'nullable',
            'is_banner_slider' => 'required',
            'banner_slider_image' => 'required_if:is_file,true',
            'speaker' => 'nullable',
        ]);

        // Upload banner image
        if ($request->hasFile('banner_image')) {
            $imagePath = $request->file('banner_image')->store('banners', 'public');
        } else {
            $imagePath = null;
        }

        // Upload banner slider image
        if ($request->hasFile('banner_slider_image')) {
            $imageSliderPath = $request->file('banner_slider_image')->store('banner_sliders', 'public');
        } else {
            $imageSliderPath = null;
        }

        $user = Auth::user();

        // Create the event
        $event = new Event();
        $event->user_id = $user->id;
        $event->category_id = $request->input('category_id');
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->date = $request->input('date');
        $event->time = $request->input('time');
        $event->location = $request->input('location');
        $event->banner_image = $imagePath;
        $event->is_banner_slider = $request->input('is_banner_slider');
        $event->banner_slider_image = $imageSliderPath;
        $event->price = $request->input('price');
        $event->speaker = $request->input('speaker');
        $event->save();

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $title = $this->title;
        $users = User::all();
        $categories = Category::all();
        $event->banner_image_url =  Storage::url($event->banner_image);
        $event->banner_slider_image_url =  Storage::url($event->banner_slider_image);

        return view('pages.events.edit', compact('title', 'event', 'users', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'banner_image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'price' => 'nullable',
            'is_banner_slider' => 'required',
            'banner_slider_image' => 'required_if:is_banner_slider,true',
            'speaker' => 'nullable',
        ]);

        $imagePath = null;
        if ($request->hasFile('banner_image')) {
            if ($event->banner_image) {
                Storage::disk('public')->delete($event->banner_image);
            }

            $imagePath = $request->file('banner_image')->store('banners', 'public');
            $event->banner_image = $imagePath;
        }

        $imageSliderPath = null;
        if ($request->hasFile('banner_slider_image')) {
            if ($event->banner_slider_image) {
                Storage::disk('public')->delete($event->banner_slider_image);
            }

            $imageSliderPath = $request->file('banner_slider_image')->store('banner_sliders', 'public');
            $event->banner_slider_image = $imageSliderPath;
        }
        
        $event->category_id = $request->input('category_id');
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->date = $request->input('date');
        $event->time = $request->input('time');
        $event->location = $request->input('location');
        $event->price = $request->input('price');
        $event->is_banner_slider = $request->input('is_banner_slider');
        if($imagePath){
            $event->banner_image = $imagePath;
        }
        if($imageSliderPath){
            $event->banner_slider_image = $imageSliderPath;
        }
        $event->speaker = $request->input('speaker');
        $event->save();

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
    
    public function indexClient()
    {
        $title = $this->title;
        $user = Auth::user();
        $registrations = Registration::where('user_id', $user->id)->with('event.certificate')->get();
        // $eventRegis = Registration::leftJoin('events', '')->where('user_id', $user->id)->get();
        // $events = Event::where('user_id', $user->id)->get();
       
        foreach ($registrations as $registration) {
            // return $registrationdate;
            $dateTime = Carbon::createFromFormat('Y-m-d H:i:s', $registration->event->date . ' ' . $registration->event->time);

            $registration->event->banner_image_url = Storage::url($registration->event->banner_image);
            $registration->event->banner_slider_image_url = Storage::url($registration->event->banner_slider_image);
            $registration->payment_status_name = $registration->payment_status == 0 ? 'Confirmation Process' : 'Paid';
            $registration->is_present_name = !$registration->is_present ? 'Not Present' : 'Present';
            $registration->has_attendance = $dateTime->isFuture();
        }
        
        return view('pages.events.clients.index', compact('title', 'registrations'));
    }
    
    // CLIENT
    public function upsertCertificate(Event $event)
    {
        $title = $this->title;
        $user = Auth::User();
        $certificate = Certificate::where('event_id', $event->id)->first();
        if(!$certificate){
            $certificate = new Certificate(); 
            $certificate->word_title = '(Example) SERTIFIKAT';
            $certificate->word_desc = '(Example) Sebagai Peserta dalam kegiatan seminar "Teknologi Untuk Perubahan Indonesia" yang dilaksanakan pada Tanggal 17 Oktober 2022 bertempat di Gojek Auditorium, Jakarta Selatan.';
            $certificate->word_speaker = '(Example) Kevin Aluwi';
            $certificate->word_organization = '(Example) CEO of PT Gojek';
            $certificate->certificate_number = '(Example) Nomor: 1023/1/JPL1110/2023';
        } 

        $certificate->logo_image_url =  Storage::url($certificate->logo_image);
        $certificate->signature_image_url =  Storage::url($certificate->signature_image);
        $certificate->background_image_url =  Storage::url($certificate->background_image);

        // return $certificate->logo_image_url;

        return view('pages.events.certificate-upsert', compact('user', 'certificate', 'event', 'title'));
    }

    // CERTIFICATES
    public function submitUpsertCertificate(Request $request, Event $event)
    {

        $user = Auth::user();
        $certificate = Certificate::where('event_id', $event->id)->first();
        if(!$certificate) {
            $certificate = new Certificate();
            
            $request->validate([
                'logo_image' => 'required|mimes:jpeg,png,jpg|max:2048',
                'signature_image' => 'required|mimes:jpeg,png,jpg|max:2048',
                'background_image' => 'required|mimes:jpeg,png,jpg|max:2048',
                'certificate_number' => 'required',
                'word_desc' => 'required',
                'word_speaker' => 'required',
                'word_title' => 'required',
                'word_organization' => 'required',
            ]);
        } else {
            $request->validate([
                'logo_image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
                'signature_image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
                'background_image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
                'certificate_number' => 'required',
                'word_desc' => 'required',
                'word_speaker' => 'required',
                'word_title' => 'required',
                'word_organization' => 'required',
            ]);
        }

        $signature_image_url = $certificate->signature_image;
        if ($request->hasFile('signature_image')) {
            if ($certificate->signature_image) {
                Storage::disk('public')->delete($certificate->signature_image);
            }

            $signature_image_url = $request->file('signature_image')->store('certificates/signature/'.$event->id, 'public');
            $certificate->signature_image = $signature_image_url;
        }
        
        $logo_image_url = $certificate->logo_image;
        if ($request->hasFile('logo_image')) {
            if ($certificate->logo_image) {
                Storage::disk('public')->delete($certificate->logo_image);
            }

            $logo_image_url = $request->file('logo_image')->store('certificates/logo/'.$event->id, 'public');
            $certificate->logo_image = $logo_image_url;
        }

        $background_image_url = $certificate->background_image;
        if ($request->hasFile('background_image')) {
            if ($certificate->background_image) {
                Storage::disk('public')->delete($certificate->background_image);
            }

            $background_image_url = $request->file('background_image')->store('certificates/background/'.$event->id, 'public');
            $certificate->background_image = $background_image_url;
        }
        
        $certificate->event_id = $event->id;
        $certificate->user_id = $user->id;
        $certificate->certificate_number = $request->input('certificate_number');
        $certificate->word_desc = $request->input('word_desc');
        $certificate->word_speaker = $request->input('word_speaker');
        $certificate->word_title = $request->input('word_title');
        $certificate->word_organization = $request->input('word_organization');

        $certificate->save();

        return redirect()->back()->with('success', 'Certificate updated successfully.');
    }

    public function generateCertificate(Event $event)
    {
        $user = Auth::User();
        $certificate = Certificate::where('event_id', $event->id)->first();
        
        $backgroundPath = public_path(Storage::url($certificate->background_image));
        $logoPath = public_path(Storage::url($certificate->logo_image));
        $signaturePath = public_path(Storage::url($certificate->signature_image));
        
        // Create new TCPDF instance
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetFont('helvetica', '', 12);
        
        // Set document information
        $pdf->SetCreator('Creator');
        $pdf->SetAuthor('Author');
        $pdf->SetTitle($event->title);
        $pdf->SetSubject('CERTIFICATE');
        
        // Add a page
        $pdf->AddPage();

        // Set background
        $bMargin = $pdf->getBreakMargin();
        $auto_page_break = $pdf->getAutoPageBreak();
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->Image($backgroundPath, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
        $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
        $pdf->setPageMark();
        
        // Set company logo
        $pdf->Image($logoPath, 135, 20, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0);

        // Set signature
        $pdf->Image($signaturePath, 130, 155, 50, '', 'PNG', '', 'T', false, 300, '', false, false, 0);

        // Set certificate title
        $pdf->SetFont('helvetica', 'B', 24);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(20, 70);
        $pdf->Cell(0, 0, $certificate->word_title, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        
        // Set certificate number
        $pdf->SetFont('helvetica', 'R', 14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(20, 77);
        $pdf->Cell(0, 0, $certificate->certificate_number, 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // Set a/n
        $pdf->SetFont('helvetica', 'R', 14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(20, 92);
        $pdf->Cell(0, 0, 'diberikan kepada', 0, false, 'C', 0, '', 0, false, 'M', 'M');
       
        // Set participant name
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(20, 100);
        $pdf->Cell(0, 0, $user->name, 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // Line
        $pdf->SetLineWidth(0.7);
        $pdf->Line(85, 105, 220, 105);

        // Set seminar details
        $pdf->SetFont('helvetica', 'R', 16);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(50, 115);
        $pdf->MultiCell(200, 0, $certificate->word_desc, 0, 'C');
        
        // Set organization
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(20, 150);
        $pdf->Cell(0, 0, $certificate->word_organization, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        
        // Set speaker name
        $orgX = 20;
        $orgY = 183;
        $speaker = $certificate->word_speaker;
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY($orgX, $orgY);
        $pdf->Cell(0, 0, $speaker, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $lineLength = $pdf->GetStringWidth($speaker);
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
