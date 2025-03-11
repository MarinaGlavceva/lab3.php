<?php
$dir = 'image/'; // Путь к папке с изображениями
$files = scandir($dir); // Получаем список файлов
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif']; // Разрешенные расширения

// Количество колонок в таблице
$columns = 3;
$index = 0;
?>

<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Галерея</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f5f5f5;
        }
        .container {
            width: 80%;
            margin: auto;
            padding-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            width: 33%;
            padding: 10px;
            text-align: center;
        }
        img {
            width: 100%;
            max-width: 200px;
            height: auto;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class='container'>
    <div class='header'>Explore a world of cats</div>
    <table>";

    <?php
if ($files !== false) {
    echo "<tr>"; // Начинаем первую строку таблицы
    foreach ($files as $file) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), $allowed_extensions)) {
            if ($index % $columns == 0 && $index != 0) {
                echo "</tr><tr>"; // Закрываем предыдущую строку и начинаем новую
            }
            echo "<td><img src='$dir$file' alt='cat'></td>";
            $index++;
        }
    }
}?>

</tr>; // Закрываем последнюю строку


</table>
</div>

</body>
</html>";
