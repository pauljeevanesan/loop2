<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use App\Models\QuizResult;
use App\Mail\CertificateAwardedMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateController extends Controller
{
    /**
     * Generate a certificate for a user for a specific course.
     *
     * @param User $user
     * @param Course $course
     * @return Certificate
     */
    public function generate(User $user, Course $course): Certificate
    {
        // 1. Define paths and data
        $templatePath = public_path('uploads/certificate-template/certificate-default.png');
        $outputPath = public_path('uploads/certificates/');
        if (!file_exists($outputPath)) {
            mkdir($outputPath, 0755, true);
        }
        $identifier = Str::uuid();
        $filename = $identifier . '.png';
        $fullPath = $outputPath . $filename;

        // 2. Use Intervention Image to create the certificate
        $image = Image::make($templatePath);

        // Add User Name (Coordinates and font size are guesses and will need refinement)
        $image->text($user->name, 400, 300, function ($font) {
            $font->file(public_path('assets/frontend/default/fonts/Roboto-Regular.ttf'));
            $font->size(32);
            $font->color('#000000');
            $font->align('center');
            $font->valign('middle');
        });

        // Add Course Name
        $image->text($course->title, 400, 400, function ($font) {
            $font->file(public_path('assets/frontend/default/fonts/Roboto-Regular.ttf'));
            $font->size(24);
            $font->color('#000000');
            $font->align('center');
            $font->valign('middle');
        });

        // Add Completion Date
        $image->text(date('F j, Y'), 400, 500, function ($font) {
            $font->file(public_path('assets/frontend/default/fonts/Roboto-Regular.ttf'));
            $font->size(20);
            $font->color('#000000');
            $font->align('center');
            $font->valign('middle');
        });

        // 3. Generate QR Code
        $verificationUrl = route('certificate.verify', ['identifier' => $identifier]);
        $qrCode = QrCode::format('png')->size(150)->generate($verificationUrl);
        $qrCodePath = public_path('uploads/qr_codes/');
        if (!file_exists($qrCodePath)) {
            mkdir($qrCodePath, 0755, true);
        }
        $qrCodeFile = $qrCodePath . $identifier . '.png';
        file_put_contents($qrCodeFile, $qrCode);

        // 4. Insert QR Code into certificate
        $image->insert($qrCodeFile, 'bottom-right', 20, 20);

        $image->save($fullPath);

        // 5. Create a record in the database
        $certificate = Certificate::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'identifier' => $identifier,
            'path' => 'uploads/certificates/' . $filename,
        ]);

        // 6. Send email to user
        Mail::to($user->email)->send(new CertificateAwardedMail($certificate));

        return $certificate;
    }

    /**
     * Show the public verification page for a certificate.
     *
     * @param string $identifier
     * @return \Illuminate\View\View
     */
    public function verify(string $identifier)
    {
        $certificate = Certificate::where('identifier', $identifier)->firstOrFail();

        // Calculate performance score
        $quizIds = $certificate->course->sections->pluck('quiz.id')->filter();
        $performanceScore = QuizResult::where('user_id', $certificate->user_id)
            ->whereIn('quiz_id', $quizIds)
            ->avg('percentage');

        return view('frontend.default.certificate.verify', [
            'certificate' => $certificate,
            'performanceScore' => round($performanceScore, 2),
        ]);
    }
}
