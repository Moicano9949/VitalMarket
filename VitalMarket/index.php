<?php
// Obtener la dirección IP del usuario
$ip = $_SERVER['REMOTE_ADDR'];

// Obtener el idioma preferido del usuario
$idioma_preferido = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); // Por ejemplo, "en", "es"

// Obtener información geográfica a partir de la IP
$url_api = "http://ip-api.com/json/{$ip}";
$informacion_ip = file_get_contents($url_api);
$datos_ip = json_decode($informacion_ip, true);

// Comprobar si la respuesta de la API es válida
if ($datos_ip['status'] == 'success') {
    $ciudad = $datos_ip['city'];
    $pais = $datos_ip['country'];
    $zona_horaria = $datos_ip['timezone'];
} else {
    // Manejar errores si la API no responde
    $ciudad = 'Desconocida';
    $pais = 'Desconocido';
    $zona_horaria = 'Desconocida';
}

// Crear un array con la información
$info_usuario = [
    'IP' => $ip,
    'Idioma Preferido' => $idioma_preferido,
    'Ciudad' => $ciudad,
    'País' => $pais,
    'Zona Horaria' => $zona_horaria,
    'Fecha' => date('Y-m-d H:i:s') // Agregar la fecha de la visita
];

// Leer el archivo JSON existente o crear uno nuevo
$archivo_json = 'informacion_usuario.json';

if (file_exists($archivo_json)) {
    $contenido_json = json_decode(file_get_contents($archivo_json), true);
} else {
    $contenido_json = [];
}

// Agregar la nueva información al array
$contenido_json[] = $info_usuario;

// Guardar el array actualizado en el archivo JSON
file_put_contents($archivo_json, json_encode($contenido_json, JSON_PRETTY_PRINT));

echo "Información almacenada exitosamente en el archivo JSON.";
<?
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalMarket - En Construcción</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos generales del sitio */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f2f2f2;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: #007bff #f3f3f3;
        }

        body::-webkit-scrollbar {
            width: 10px;
        }

        body::-webkit-scrollbar-thumb {
            background-color: #007bff;
            border-radius: 10px;
        }

        body::-webkit-scrollbar-track {
            background-color: #f3f3f3;
        }

        header {
            text-align: center;
            padding: 20px;
            background-color: #007bff;
            color: #fff;
            position: relative;
        }

        h1 {
            font-size: 48px;
            margin: 0;
            font-weight: 700;
            animation: fadeDown 1.2s ease-out;
        }

        .construction-message {
            text-align: center;
            margin: 60px auto;
            animation: fadeInUp 1.5s ease-out;
        }

        .construction-message h2 {
            color: #007bff;
            font-size: 36px;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .construction-message p {
            color: #333;
            font-size: 18px;
            margin-bottom: 20px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .construction-icon {
            font-size: 100px;
            color: #007bff;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        .button-container {
            margin-top: 40px;
        }

        .return-button {
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 18px;
            transition: background-color 0.3s ease;
            font-weight: 500;
        }

        .return-button:hover {
            background-color: #0056b3;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 36px;
            }

            .construction-message h2 {
                font-size: 28px;
            }

            .construction-message p {
                font-size: 16px;
            }

            .construction-icon {
                font-size: 80px;
            }

            .return-button {
                font-size: 16px;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>VitalMarket</h1>
    </header>

    <div class="construction-message">
        <div class="construction-icon">🚧</div>
        <h2>Sitio en Construcción</h2>
        <p>Estamos trabajando arduamente para ofrecerte la mejor experiencia. Por favor, regresa más tarde para ver todas las novedades que estamos preparando.</p>

        <div class="button-container">
            <a href="/VitalMarket/Login.php" class="return-button">VitalMarket - Construccion</a>
        </div>
    </div>
</body>
</html>
