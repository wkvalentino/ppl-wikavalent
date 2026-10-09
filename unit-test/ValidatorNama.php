<?php
function validateName($name) {
    // Menghapus spasi di awal/akhir untuk pengecekan kosong
    $trimmedName = trim($name);
    
    if (empty($trimmedName)) {
        throw new InvalidArgumentException('Nama tidak boleh kosong.');
    }
    
    // Memastikan hanya berisi huruf (a-z, A-Z) dan spasi
    if (!preg_match("/^[a-zA-Z\s]+$/", $trimmedName)) {
        throw new InvalidArgumentException('Nama hanya boleh berupa huruf.');
    }
    
    return true;
}