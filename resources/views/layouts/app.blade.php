<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SARPRAS SMKN 1 Tirtamulya</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwindcss -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- DaisyUI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .custom-input {
            background-color: #F9FAFB;
            border: 1px solid #D1D5DB;
            color: #000;
            border-radius: 0.5rem;
            padding: 0.5rem;
            width: 100%;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .custom-input:focus {
            border-color: #1F2937;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.5);
            outline: none;
        }

        .custom-file-input {
            background-color: #F9FAFB;
            border: 1px solid #D1D5DB;
            color: #000;
            border-radius: 0.5rem;
            width: 100%;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .custom-file-input:focus {
            border-color: #1F2937;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.5);
            outline: none;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #D1D5DB;
            border-radius: 0.5rem;
            z-index: 10;
        }

        .dropdown-item {
            padding: 0.625rem 1rem;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #000000;
            color: white;
        }
    </style>
</head>

<body class="font-montserrat antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')
        @if (session('success') || session('error'))
            <div id="flash-message"
                class="absolute top-24 left-[5%] md:left-[34.5%] z-20 flex items-center p-5 shadow-lg rounded-lg w-[90%] max-w-[500px]"
                style="background-color: rgb(255, 255, 255); visibility: hidden;">
                <i
                    class="{{ session('success') ? 'fas fa-check-circle text-green-800' : 'fas fa-exclamation-circle text-red-800' }} text-xl flex-shrink-0 inline mr-4"></i>
                <span class="sr-only">{{ session('success') ? 'Success' : 'Error' }}</span>
                <div class="{{ session('success') ? 'text-green-800' : 'text-red-800' }}">
                    {{ session('success') ?? session('error') }}
                </div>
            </div>
        @endif
        <main class="mt-20">
            {{ $slot }}
        </main>
    </div>

    <script>
        // Menu Handler
        function menuHandler() {
            return {
                open: false,
                sidebar: null,

                init() {
                    this.sidebar = document.getElementById('mobileSidebar');
                },

                toggleMenu() {
                    this.open = !this.open;
                    if (this.open) {
                        this.sidebar.style.display = 'block';
                        gsap.set(this.sidebar, {
                            x: '100%',
                            opacity: 0
                        });

                        gsap.to(this.sidebar, {
                            x: 0,
                            opacity: 1,
                            duration: 0.4,
                            ease: 'power3.out',
                        });
                    } else {
                        gsap.to(this.sidebar, {
                            x: '100%',
                            opacity: 0,
                            duration: 0.3,
                            ease: 'power2.in',
                            onComplete: () => {
                                this.sidebar.style.display = 'none';
                            }
                        });
                    }
                }
            };
        }

        // Dropdown Toggle
        function toggleDropdown(menuId) {
            const menu = document.getElementById(menuId);
            menu.style.display = menu.style.display === "none" || menu.style.display === "" ? "block" : "none";
        }

        // Dropdown Select Option
        function selectOption(value, buttonId, inputId, label = null) {
            const button = document.getElementById(buttonId);
            const span = button.querySelector('span');
            const input = document.getElementById(inputId);

            if (span) span.textContent = label || value;
            if (input) input.value = value;

            const dropdownMenus = document.querySelectorAll('.dropdown-menu');
            dropdownMenus.forEach(menu => menu.style.display = 'none');
        }

        // Dropdown Event Listener
        document.addEventListener('click', function(event) {
            const isClickInside = event.target.closest('.dropdown');
            if (!isClickInside) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.style.display = 'none';
                });
            }
        });

        // Flash Message
        document.addEventListener("DOMContentLoaded", function() {
            const flashMessage = document.getElementById("flash-message");
            if (flashMessage) {
                flashMessage.style.visibility = "visible";

                gsap.fromTo(
                    flashMessage, {
                        opacity: 0,
                        y: -20,
                    }, {
                        opacity: 1,
                        y: 0,
                        duration: 0.5,
                        ease: "power1.out",
                    }
                );

                setTimeout(function() {
                    gsap.to(flashMessage, {
                        opacity: 0,
                        y: -20,
                        duration: 0.5,
                        ease: "power1.in",
                        onComplete: function() {
                            flashMessage.style.visibility = "hidden";
                        }
                    });
                }, 3000);
            }
        });
    </script>
</body>

</html>
