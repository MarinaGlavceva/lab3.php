<?php

declare(strict_types=1);

// Массив транзакций
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
    [
        "id" => 3,
        "date" => "2021-06-10",
        "amount" => 200.25,
        "description" => "Monthly subscription",
        "merchant" => "Online Service",
    ],
    [
        "id" => 4,
        "date" => "2022-11-22",
        "amount" => 50.00,
        "description" => "Taxi fare",
        "merchant" => "City Taxi",
    ],
];


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

// Сортировка по дате (от новых к старым)
usort($transactions, fn($a, $b) => strtotime($b["date"]) - strtotime($a["date"]));

// Сортировка по сумме (по убыванию)
usort($transactions, fn($a, $b) => $b["amount"] <=> $a["amount"]);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Транзакции</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

    <h2>Список транзакций</h2>

    <table>
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
        <td><?= $formattedDate ?> дней</td>
    </tr>
<?php } ?>

        </tbody>
    </table>

    <h3>Общая сумма транзакций: <?= number_format(calculateTotalAmount($transactions), 2) ?> $</h3>

</body>
</html>


