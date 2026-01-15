<?php

$arr = [];
for ($i = 0; $i < 5; $i++) {
    for ($j = 0; $j < 7; $j++) {
        $arr[$i][$j] = rand(1, 1000);
    }
}

// сделал кастомный вывод, а не print_r, чтобы удобнее было проверять
foreach ($arr as $row) {
    foreach ($row as $number) {
        echo str_pad($number, 5, " ", STR_PAD_LEFT);
    }
    echo "\n";
}

echo "\nСуммы строк:\n";
foreach ($arr as $i => $row) {
    echo "Строка " . ($i + 1) . ": " . array_sum($row) . "\n";
}

echo "\nСуммы колонок:\n";
for ($j = 0; $j < count($arr[0]); $j++) {
    echo "Колонка " . ($j + 1) . ": " . array_sum(array_column($arr, $j)) . "\n";
}