<?php

ob_start();

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = 'rootroot';
const DB_NAME = 'cms';

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// if ($connection) {
//     echo '資料庫--連線!';
// } else {
//     echo '資料庫--未連線!';
// }