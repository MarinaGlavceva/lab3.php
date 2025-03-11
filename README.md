# Лабораторная работа №3: Массивы и Функции в PHP

## Цель работы

В рамках данной лабораторной работы я освоила работу с массивами в PHP, научилась применять различные операции, такие как создание, добавление, удаление, сортировка и поиск. Кроме того, я закрепила навыки работы с функциями, включая передачу аргументов, возвращаемые значения и анонимные функции.

## Выполненные задания

### 1. Работа с массивами

#### 1.1. Подготовка среды

Я убедилась, что у меня установлен PHP 8+, и создала новый PHP-файл `index3.php`. В начале файла включила строгую типизацию:

```php
<?php

declare(strict_types=1);
```

#### 1.2. Создание массива транзакций

Я создала массив `$transactions`, содержащий информацию о банковских транзакциях. Пример структуры:

```php
$transactions = [
    [
        "id" => 1,
        "date" => "2019-01-01",
        "amount" => 100.00,
        "description" => "Payment for groceries",
        "merchant" => "SuperMart",
    ],
    [
        "id" => 2,
        "date" => "2020-02-15",
        "amount" => 75.50,
        "description" => "Dinner with friends",
        "merchant" => "Local Restaurant",
    ],
];
```

#### 1.3. Вывод списка транзакций

Я использовала `foreach`, чтобы вывести список транзакций в HTML-таблице:

```php
<table border='1'>
<thead>
    <tr>
        <th>ID</th>
        <th>Дата</th>
        <th>Сумма</th>
        <th>Описание</th>
        <th>Получатель</th>
        <th>Дней назад</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($transactions as $transaction) {
        $formattedDate = (new DateTime($transaction["date"]))->format("d-m-Y"); ?>
        <tr>
            <td><?= ((string) $transaction["id"]) ?></td>
            <td><?= $formattedDate ?></td>
            <td><?= number_format($transaction["amount"], 2) ?> $</td>
            <td><?= $transaction["description"] ?></td>
            <td><?= $transaction["merchant"] ?></td>
            <td><?= daysSinceTransaction($transaction["date"]) ?> дней</td>
        </tr>
    <?php } ?>
</tbody>
</table>
```

#### 1.4. Реализация функций

Я реализовала следующие функции:

- `calculateTotalAmount(array $transactions): float` — вычисляет общую сумму всех транзакций.
- `findTransactionByDescription(string $descriptionPart)` — ищет транзакцию по части описания.
- `findTransactionById(int $id)` — ищет транзакцию по идентификатору (сначала с `foreach`, затем с `array_filter`).
- `daysSinceTransaction(string $date): int` — возвращает количество дней с момента транзакции.
- `addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void` — добавляет новую транзакцию.

```php

// Функция вычисления общей суммы
function calculateTotalAmount(array $transactions): float {
    return array_sum(array_column($transactions, "amount"));
}

// Функция поиска по описанию
function findTransactionByDescription(string $descriptionPart) {
    global $transactions;
    return array_filter($transactions, fn($t) => stripos($t["description"], $descriptionPart) !== false);
}

// Функция поиска по ID (обычный цикл foreach)
function findTransactionById(int $id) {
    global $transactions;
    foreach ($transactions as $transaction) {
        if ($transaction["id"] === $id) {
            return $transaction;
        }
    }
    return null;
}

// Функция поиска по ID (с array_filter)
function findTransactionByIdFilter(int $id) {
    global $transactions;
    $result = array_filter($transactions, fn($t) => $t["id"] === $id);
    return reset($result) ?: null;
}

// Функция вычисления количества дней с даты транзакции
function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date);
    $now = new DateTime();
    return $now->diff($transactionDate)->days;
}

// Функция добавления новой транзакции
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions;
    $transactions[] = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];
}
```

#### 1.5. Сортировка транзакций

Я отсортировала массив транзакций:

- По дате с использованием `usort()`:
  
  ```php
  usort($transactions, fn($a, $b) => strtotime($b['date']) - strtotime($a['date']));
  ```
  
- По сумме (по убыванию):
  
  ```php
  usort($transactions, fn($a, $b) => $b['amount'] <=> $a['amount']);
  ```

### 2. Работа с файловой системой

Я создала директорию `image`, в которой разместила 20-30 изображений `.jpg`. Затем создала веб-страницу с заголовком, меню, контентом и футером. Изображения были выведены в виде галереи с помощью `scandir()`:

```php
$dir = 'image/';
$files = scandir($dir);
if ($files !== false) {
    $images = array_filter($files, fn($file) => preg_match('/\.(jpg|jpeg|png|gif)$/i', $file));
    foreach ($images as $image) {
        echo "<img src='$dir$image' alt='Image' width='150'>";
    }
}
```

## Контрольные вопросы

1. **Что такое массивы в PHP?**
   
   Массив в PHP — это структура данных, позволяющая хранить несколько значений в одной переменной. 

2. **Каким образом можно создать массив в PHP?**
   
   Массив можно создать с помощью литерала массива `[]` или функции `array()`:
   
   ```php
   $arr = [1, 2, 3];
   $arr = array(1, 2, 3);
   ```

3. **Для чего используется цикл `foreach`?**
   
   Цикл `foreach` предназначен для перебора элементов массива. Он автоматически извлекает элементы и позволяет работать с ними внутри тела цикла:
   
   ```php
   foreach ($arr as $value) {
       echo $value;
   }
   ```

## Вывод

В ходе работы я освоила работу с массивами в PHP, научилась их сортировать, фильтровать и выполнять поиск. Также закрепила знания о функциях, их параметрах и возвращаемых значениях. Дополнительно изучила работу с файлами и директориями, реализовав простую галерею изображений.


