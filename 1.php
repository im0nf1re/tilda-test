<?php
$currentNumber = 1;
$lineLength = 1;

while ($currentNumber <= 100) {
    for ($i = 0; $i < $lineLength; $i++) {
        if ($currentNumber > 100) {
            break;
        }
        echo $currentNumber . " ";
        $currentNumber++;
    }
    echo "\n";
    $lineLength++;
}