<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Ivy Streams</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href="{{ asset('assets/css/main.css') }}">
</head>

<body>

    <button id="join-btn">Join Stream</button>

    <div id="stream-wrapper">
        <div id="video-streams"></div>

        <div id="stream-controls">
            <button id="leave-btn">Leave Stream</button>
            <button id="mic-btn">Mic On</button>
            <button id="camera-btn">Camera on</button>
        </div>
    </div>

</body>
<script>
    const APP_ID = "b447fb0548b847448cd95024a8633a5b"
    const CHANNEL = "{{ $channel }}"
    const TOKEN = "{{ $token }}";
    const user_id = {{ $user_id }};
</script>
<script src="{{ asset('assets/js/AgoraRTC_N-4.7.3.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

</html>
