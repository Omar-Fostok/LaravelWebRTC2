<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-DDQR2KfM.css') }}"> --}}
    {{-- <script src="{{ asset('build/assets/app-qOltvf0N.js') }}"></script> --}}

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900" id="toblur">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <style>
        .blur {
            filter: blur(5px);
            -webkit-filter: blur(5px);

        }


        #calling {
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            z-index: 9999;
            position: absolute;
            top: 0;
            display: none;
        }

        #caller_name {
            width: 100%;
            margin: auto;
            margin-top: 200px;
            text-align: center;
        }

        .buttons {
            position: absolute;
            bottom: 100px;
            width: 50%;
            margin-left: 25%;

        }

        .butt {
            padding: 10px;
            border-radius: 10px;

        }

        #accept {
            background-color: green;
            float: right
        }

        #accept:hover {
            background-color: rgb(1, 83, 1);
            cursor: pointer;
        }

        #reject:hover {
            background-color: rgb(153, 0, 0);
            cursor: pointer;
        }

        #reject {
            background-color: red;
            float: left;
        }
    </style>

    <div id="calling">
        <h1 id="caller_name" class="text-xl">Omar Fostok is calling...</h1>
        <div class="buttons">
            <div class="butt" id="accept">Accept</div>
            <div class="butt" id="reject">Reject</div>
        </div>
    </div>

    @vite('resources/js/app.js')
    {{-- <script src="{{ asset('build/assets/app-qOltvf0N.js') }}"></script> --}}

    <script>
        let channelName;
        setTimeout(() => {
            window.Echo.private("{{ 'channel-user-' . Auth::user()->id }}")
                .listen('CallUser', (e) => {
                    document.getElementById('calling').style.display = 'block';
                    document.getElementById('toblur').classList.add('blur');
                    document.getElementById('caller_name').textContent = e.name + " is calling...";
                    audio.play();
                    audio.addEventListener('ended', function() {
                        audio.currentTime = 0; // Reset the audio to the beginning
                        audio.play(); // Play the audio again
                    });
                    channelName = e.channel;
                });
        }, 200);

        document.getElementById('reject').addEventListener('click', function() {
            document.getElementById('calling').style.display = 'none';
            document.getElementById('toblur').classList.remove('blur');
            audio.pause();
        });
        document.getElementById('accept').addEventListener('click', function() {
            audio.pause();
            window.location = '/index?channel=' + channelName;
        });
    </script>
</body>
<script>
    var audio = new Audio("{{ asset('assets/sound.mp3') }}"); // Replace 'ring.mp3' with the path to your audio file
</script>

</html>
