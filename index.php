<!DOCTYPE html>
<html>
<head>
    <title>Consumir API</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        }
    h1 {
        text-align: center;
        margin-top: 50px;
    }

    form {
        max-width: 500px;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 5px; 
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #cccccc;
    }

    input[type="submit"] {
        display: block;
        width: 100%;
        padding: 10px;
        margin-top: 20px;
        font-size: 16px;
        font-weight: bold;
        color: #ffffff;
        background-color: #007bff;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }

    ul {
        list-style: none;
        padding: 0;
    }

    li {
        margin-bottom: 20px;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    li:last-child {
        margin-bottom: 0;
    }

    strong {
        font-weight: bold;
    }

    .error {
        color: #ff0000;
        font-weight: bold;
    }

    .no-results {
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
    }
</style>

</head>
<body>
    <h1>Consumir API</h1>

<?php
// URL de tu API
$apiUrl = 'https://usuario40.talleresmelipilla.cl/integracion_plataformas/pc/apiPropia/envio.php';
?>


<form action="" method="POST">
    <label for="nombre">Nombre del producto:</label>
    <input type="text" id="nombre" name="nombre" placeholder="Nombre instrumento">

    <input type="submit" value="Buscar">
</form>

<?
if (isset($_POST['nombre'])) {
    // Obtener el nombre del producto desde el formulario
    $nombre = $_POST['nombre'];

    // Realizar una solicitud GET para obtener los productos por nombre
    $url = $apiUrl . '?nombre=' . urlencode($nombre);
    $response = file_get_contents($url);

    if ($response !== false) {
        $data = json_decode($response, true);

        if ($data !== null) {
            if (isset($data['error'])) {
                echo '<p class="error">Error: ' . $data['error'] . '</p>';
            } else {
                if (count($data) > 0) {
                    echo '<h2>Productos encontrados:</h2>';
                    echo '<ul>';

                    foreach ($data as $producto) {
                        echo '<li>';
                        echo '<strong>Nombre:</strong> ' . $producto['nombre'] . '<br>';
                        echo '<strong>Precio:</strong> ' . $producto['precio'] . '<br>';
                        echo '<strong>Categoría:</strong> ' . $producto['categoria'] . '<br>';
                        echo '<strong>Stock:</strong> ' . $producto['stock'] . '<br>';
                        echo '<strong>URL de imagen:</strong> ' . $producto['img_url'] . '<br>';
                        echo '</li>';
                    }

                    echo '</ul>';
                } else {
                    echo '<p class="no-results">No se encontraron productos con el nombre "' . $nombre . '"</p>';
                }
            }
        } else {
            echo '<p class="error">Error: Respuesta no válida desde la API.</p>';
        }
    } else {
        echo '<p class="error">Error: No se pudo conectar a la API.</p>';
    }
}
?>

</body>
</html>
