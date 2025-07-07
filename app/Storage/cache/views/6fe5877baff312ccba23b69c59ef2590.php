<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTV2Ztz7uNKx5W4ZwFxFc00k6QjBgT_2y8A6w&s" type="image/x-icon">
    <title>Civil Praktikum</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#468B97',
                        background: '#E0E8E9',
                        accent: '#FEE500'
                    },
                    fontFamily: {
                        headline: ['Space Grotesk', 'sans-serif'],
                        body: ['Inter', 'sans-serif']
                    },
                    boxShadow: {
                        'soft': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.05)'
                    },
                    transitionProperty: {
                        'height': 'height',
                        'spacing': 'margin, padding'
                    }
                }
            }
        }
    </script>
    <style>
        .error-container {
            min-height: calc(100vh - 160px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-content {
            max-width: 600px;
            text-align: center;
        }

        .error-number {
            font-size: 8rem;
            font-weight: 900;
            line-height: 1;
            color: #468B97;
            opacity: 0.2;
            margin-bottom: 1rem;
        }

        .error-animation {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>

<body class="bg-background min-h-screen flex flex-col font-body antialiased">
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md shadow-soft">
        <div class="container mx-auto flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="/"
                class="flex items-center gap-3 font-bold text-xl font-headline transition-colors hover:text-primary"
                aria-label="Beranda Civil Praktikum">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                    stroke="#468B97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-hard-hat">
                    <path d="M2 18a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v2z" />
                    <path d="M10 10V5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5" />
                    <path d="M4 15v-3a6 6 0 0 1 6-6h0" />
                    <path d="M14 6h0a6 6 0 0 1 6 6v3" />
                </svg>
                <span>Civil Praktikum</span>
            </a>
            <nav class="flex items-center gap-4">
                <?php
                $userRole = isset($_SESSION['user']['role_name']) ? $_SESSION['user']['role_name'] : null;
                ?>
                <?php if($userRole == null): ?>
                    <a href="/login"
                        class="text-sm font-medium text-gray-700 hover:text-primary px-4 py-2 rounded-md transition-colors"
                        aria-label="Masuk ke akun">Login</a>
                    <a href="/register"
                        class="text-sm font-medium bg-primary text-white hover:bg-primary/90 px-4 py-2 rounded-md transition-colors"
                        aria-label="Daftar akun baru">Register</a>
                <?php else: ?>
                    <a href="/logout"
                        class="text-sm font-medium bg-primary text-white hover:bg-primary/90 px-4 py-2 rounded-md transition-colors"
                        aria-label="Daftar akun baru">Logout</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Error Content -->
    <main class="flex-1">
        <div class="error-container">
            <div class="error-content">
                <!-- Error Number -->
                <?php echo $__env->yieldContent('content-error'); ?>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200/50 mt-auto">
        <div class="container mx-auto py-8 text-center text-sm text-gray-600">
            <p>© 2025 Civil Praktikum Manager. All rights reserved.</p>
        </div>
    </footer>
</body>

</html><?php /**PATH C:\laragon\www\services/errors/layout/layout.blade.php ENDPATH**/ ?>