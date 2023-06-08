<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script>
        /// en Vanilla JS
        function sumar() {
            let contador = document.getElementById ('miContador');
            if (contador) {

                let val = parseInt (contador.innerHTML);
                val++;
                contador.innerHTML = val;
                
            }
            
        }
    </script>

@livewireStyles
</head>
<body>
    <h1>Formato clásico con HTTP request</h1>
    <form method="post">
        @csrf
        <h1>{{ $counter }}</h1>
        <button type="submit">Sumar</button>
    </form>
    <hr>
    <h1>Y ahora con Javascript</h1>
    <h1 id="miContador">0</h1>
    <button onclick="sumar()">Sumar con JS</button>
    <hr>
    <h1>Y ahora con Livewire</h1>
    <livewire:counter />
    



    @livewireScripts
</body>
</html>