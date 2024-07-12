<!DOCTYPE html>
<html>
<head>
    <title>Invitation</title>
</head>
<body>
    <h1>Invitation</h1>
    <p>This is a mail to invite you to a Project {{ $project_name }} </p>
    {{-- استدعاء رابط api --}}
    <p>Click <a href="{{ route('accept-invitation', ['invitation_id' => $invitation_id , 'email' => $email]) }}">Here</a> to accept the invitation.</p>
</body>
</html>
