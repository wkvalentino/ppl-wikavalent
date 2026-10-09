<?php
//file: test_age.php
require_once 'Validator.php';

//Test Case 1: umur valid
try{
    $result = validateAge(25);
    echo "PASS: umur 25 diterima\n";
} catch (Exception $e) {
    echo "FAIL: umur 25 tidak diterima. Error: " . $e->getMessage() . "\n";
}

//Test Case 2: umur negatif
try{
    $result = validateAge(-5);
    echo "FAIL: umur -5 seharusnya ditolak\n";
} catch (Exception $e) {
    echo "PASS: umur -5 ditolak. Error: " . $e->getMessage() . "\n";
}

