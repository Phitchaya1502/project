<?php
// config.php
const DB_HOST = '127.0.0.1';
const DB_NAME = 'footballstorev2';
const DB_USER = 'root';
const DB_PASS = ''; // ใส่ของคุณ

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$pdo = new PDO(
  "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
  DB_USER,
  DB_PASS,
  [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]
);
