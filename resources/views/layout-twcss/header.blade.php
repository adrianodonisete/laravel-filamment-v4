<!doctype html>
<html lang="pt-BR" class="h-full" x-data="{ dark: JSON.parse(localStorage.getItem('dark') ?? 'false') }" x-init="$watch('dark', v => localStorage.setItem('dark', JSON.stringify(v)))" :class="{ 'dark': dark }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'GLPI Controle' }}</title>
    <!-- Tailwind CSS v4 via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Tailwind config for dark mode class strategy
        tailwind.config = {
            darkMode: 'class'
        };
    </script>
    <script>
        document.documentElement.classList.toggle('dark', JSON.parse(localStorage.getItem('dark') ?? 'false'))
    </script>
    <script src="https://unpkg.com/alpinejs@3.x.x" defer></script>
</head>

<body class="min-h-screen bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 flex flex-col">
