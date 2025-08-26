<!DOCTYPE html>
<html>
<head>
    <title>Certificate of Completion</title>
</head>
<body>
    <h1>Congratulations, {{ $certificate->user->name }}!</h1>
    <p>We are pleased to inform you that you have successfully completed the course: <strong>{{ $certificate->course->title }}</strong>.</p>
    <p>Your certificate is attached to this email. You can also view and share it from your profile.</p>
    <p>Well done, and we look forward to seeing you in another course soon!</p>
    <p>Best regards,<br>The StudAI Loop Team</p>
</body>
</html>
