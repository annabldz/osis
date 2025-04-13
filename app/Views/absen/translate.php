<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Switch Bahasa</title>
</head>
<body>
    <div id="google_translate_element">
    <button onclick="gantiBahasa('id')">🇮🇩 Indonesia</button>
    <button onclick="gantiBahasa('en')">🇬🇧 English</button>
</div>
    <h1 id="judul" data-id="Halo, Selamat Datang!" data-en="Hello, Welcome!">Halo, Selamat Datang!</h1>
    <p id="deskripsi" data-id="Ini adalah contoh switch bahasa menggunakan JavaScript." 
        data-en="This is an example of language switch using JavaScript.">
        Ini adalah contoh switch bahasa menggunakan JavaScript.
    </p>

    <script>
        function gantiBahasa(bahasa) {
            document.querySelectorAll("[data-id]").forEach(el => {
                el.textContent = el.getAttribute(`data-${bahasa}`);
            });
        }
    </script>

</body>
</html>
