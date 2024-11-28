<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalMarket</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: radial-gradient(circle, rgba(28, 40, 51, 1) 0%, rgba(48, 63, 84, 1) 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            font-family: 'Arial', sans-serif;
        }

        /* Estilos para la pantalla de carga */
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);  /* Fondo oscuro con algo de transparencia */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            font-size: 36px;
            font-weight: bold;
            color: #00ffcc;
            flex-direction: column;
            text-align: center;
            transition: opacity 1s ease-out; /* Transición suave para ocultar la pantalla */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        #loading-screen.hidden {
            opacity: 0;
            pointer-events: none;
        }

        /* Animación de las letras con efecto 3D */
        .letter {
            display: inline-block;
            opacity: 0;
            transform: rotateX(0deg);
            transition: opacity 0.3s ease-in-out, transform 0.6s ease-in-out;
        }

        .letter.show {
            opacity: 1;
            transform: rotateX(360deg); /* Efecto 3D de rotación */
        }

        /* Animación del fondo de partículas */
        @keyframes particles {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(50px, 50px) scale(1.5); }
            100% { transform: translate(0, 0) scale(1); }
        }

        .particle {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: particles 5s infinite ease-in-out;
            opacity: 0.8;
        }

        /* Estilo para el footer */
        #footer {
            font-size: 18px;
            margin-top: 20px;
            color: #00ffcc;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 400;
            opacity: 0.8;
        }

        /* Estilo para el contenido principal */
        #main-content {
            display: none;
            text-align: center;
        }

        #main-content.visible {
            display: block;
            transition: opacity 1s ease-in-out; /* Transición suave al mostrar el contenido */
            opacity: 1;
        }

        h1 {
            font-size: 50px;
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        p {
            font-size: 20px;
            color: #fff;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }
    </style>
</head>
<body>

    <!-- Pantalla de carga -->
    <div id="loading-screen">
        <div id="loading-text"></div>
        <div id="footer">VitalMarket - Todos los derechos reservados &copy; 2024</div>
    </div>

    <!-- Contenido principal de la página -->
    <div id="main-content">
        <h1>Bienvenido a VitalMarket</h1>
        <p>Este es el contenido de la página.</p>
    </div>

    <!-- Partículas flotantes -->
    <div class="particle" style="width: 10px; height: 10px; top: 10%; left: 30%; animation-delay: 0s;"></div>
    <div class="particle" style="width: 15px; height: 15px; top: 20%; left: 50%; animation-delay: 1s;"></div>
    <div class="particle" style="width: 12px; height: 12px; top: 40%; left: 70%; animation-delay: 2s;"></div>
    <div class="particle" style="width: 20px; height: 20px; top: 60%; left: 80%; animation-delay: 3s;"></div>

    <script>
        const targetText = "VitalMarket";  // El texto a mostrar
        const loadingTextElement = document.getElementById("loading-text");
        const letterChangeDuration = 100;  // Tiempo entre cada cambio de letra en milisegundos
        const delayBeforeShowContent = 3000; // Tiempo de espera en milisegundos (3 segundos)

        // Crear un span por cada letra del texto "VitalMarket"
        function createLetters() {
            for (let i = 0; i < targetText.length; i++) {
                const letterSpan = document.createElement('span');
                letterSpan.classList.add('letter');
                letterSpan.textContent = targetText[i];
                loadingTextElement.appendChild(letterSpan);
            }
        }

        // Función que va mostrando las letras una por una
        function animateLoadingText() {
            const letters = document.querySelectorAll('.letter');
            let index = 0;

            function showLetter() {
                if (index < letters.length) {
                    letters[index].classList.add('show');  // Hace visible la letra con el efecto 3D
                    index++;
                    setTimeout(showLetter, letterChangeDuration);  // Llama recursivamente con un intervalo
                } else {
                    // Espera 3 segundos después de completar la animación antes de ocultar la pantalla de carga
                    setTimeout(hideLoadingScreen, 2000); 
                }
            }

            showLetter();  // Inicia la animación
        }

        // Función para ocultar la pantalla de carga
        function hideLoadingScreen() {
            const loadingScreen = document.getElementById("loading-screen");
            const mainContent = document.getElementById("main-content");

            loadingScreen.classList.add("hidden");

            // Espera 2 segundos después de la animación para mostrar el contenido
            setTimeout(() => {
                mainContent.classList.add("visible");  // Muestra el contenido principal de la página
            }, 500);  // Tiempo suficiente para que termine la transición de ocultar
        }

        // Inicia la animación cuando la página esté cargada
        window.addEventListener("load", function() {
            createLetters();  // Crea las letras de la animación
            animateLoadingText();  // Inicia la animación
        });
    </script>

</body>
</html>
