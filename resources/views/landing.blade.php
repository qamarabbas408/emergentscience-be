<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emerging Science</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100 antialiased">
    <main class="min-h-screen flex flex-col items-center justify-center px-6">
        <p class="text-sm font-semibold tracking-widest text-cyan-400 uppercase mb-6">Open Access Publishing Platform</p>
        <h1 class="text-5xl md:text-6xl font-bold tracking-tight text-center">
            Emerging <span class="text-cyan-400">Science</span>
        </h1>
        <p class="mt-6 max-w-xl text-center text-slate-400">
            A journal submission, peer-review, and production system built for emerging research.
        </p>
        <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
            <a href="/docs/api" class="rounded-lg bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 hover:bg-cyan-400 transition">
                API Docs
            </a>
            <a href="/admin" class="rounded-lg border border-slate-700 px-6 py-3 text-sm font-semibold text-slate-300 hover:border-slate-500 hover:text-white transition">
                Admin Panel
            </a>
        </div>
        <p class="mt-16 text-xs text-slate-600">API status: <span class="text-emerald-400">ok</span> &middot; Laravel {{ app()->version() }}</p>
    </main>
</body>
</html>
