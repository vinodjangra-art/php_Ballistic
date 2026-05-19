<?php
http_response_code(404);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>404- Not Found</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-zinc-950 text-white min-h-screen flex items-center justify-center px-6">

    <div class="w-full max-w-2xl bg-zinc-900 border border-zinc-800 rounded-3xl shadow-2xl p-10">

        <!-- Header -->
        <div class="flex items-center gap-5 mb-8">

            <div class="w-20 h-20 rounded-2xl bg-red-500/10 border border-red-500/20 flex items-center justify-center text-4xl">
                ⚠️
            </div>

            <div>
                <h1 class="text-7xl font-black leading-none">404</h1>
                <p class="text-zinc-400 text-lg mt-2">
                    The page you're looking for doesn't exist.
                </p>
            </div>

        </div>

        

        <!-- Buttons -->
        <div class="flex flex-wrap gap-4 mt-8">

            <a href=""
               class="px-6 py-3 rounded-2xl bg-white text-black font-semibold hover:scale-105 transition duration-300">
                Reload Page
            </a>

            <a href="/"
               class="px-6 py-3 rounded-2xl border border-zinc-700 hover:bg-zinc-800 transition duration-300">
                Go Home
            </a>

        </div>

       

    </div>

</body>
</html>