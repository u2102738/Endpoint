<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Notification</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2>Hello {{ $agent->username }},</h2>
        <p>This is a notification email from your application.</p>

        <p>Details about the agent:</p>
        <ul>
            <li><strong>Agent ID:</strong> {{ $agent->id }}</li>
            <li><strong>Username:</strong> {{ $agent->username }}</li>
            <li><strong>Status:</strong> {{ $agent->status }}</li>
            <!-- Add any other relevant details here -->
        </ul>

        <p>You can download the attachment using the link below:</p>
        <a href="{{ asset($agent->link_path) }}" download="{{ $agent->username }}_attachment">Download Attachment</a>

        <p>If you have any questions or concerns, please contact support.</p>

        <p>Thank you,<br>
        Your Application Team</p>
    </div>
</body>
</html>