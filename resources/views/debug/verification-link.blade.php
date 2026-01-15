<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Debug Verification Link</title>
</head>
<body>
    <h1>Debug Verification Link</h1>

    <p><strong>Generated Link:</strong> <a href="{{ $directLink }}">{{ $directLink }}</a></p>
    <p><strong>Scheme:</strong> {{ $scheme }}</p>
    <p><strong>Host:</strong> {{ $host }}</p>
    <p><strong>Environment:</strong> {{ $app_env }}</p>
    <p><strong>App Key Set:</strong> {{ $app_key_set ? 'Yes' : 'No' }}</p>
</body>
</html>