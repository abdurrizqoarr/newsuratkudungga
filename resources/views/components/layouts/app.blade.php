<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @vite('resources/css/app.css')
</head>

<body>

    {{ $slot }}

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('notify', (data) => {
                console.log(data);
                const type = data[0].type;
                const message = data[0].message;

                const toast = document.createElement('div');
                toast.innerText = message;
                toast.className = `fixed top-5 right-5 px-4 py-2 rounded shadow-lg text-white 
                               ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
                document.body.appendChild(toast);

                setTimeout(() => toast.remove(), 3000);
            });
        });
    </script>
</body>

</html>
