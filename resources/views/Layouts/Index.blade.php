<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Default Title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            900: '#0c4a6e',
                        },
                        dark: {
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .risk-level-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .risk-level-card:hover .risk-level-content {
            transform: translateY(-2px);
            border-color: currentColor;
        }

        .risk-level-content {
            border-radius: 12px;
            padding: 12px 8px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .risk-percent-radio:checked+.risk-level-content {
            border-width: 3px;
            border-color: currentColor;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
            transform: scale(1.05);
        }

        /* Animasi untuk card metrics */
        .group:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Gradient animasi untuk header */
        /* .bg-gradient-to-br {
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
        } */

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-dark-900 to-primary-900 font-sans text-gray-200 min-h-screen">
    @yield('content')
</body>

</html>
