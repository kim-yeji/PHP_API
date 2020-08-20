<?php

//DB 정보
function pdoSqlConnect()
{
    try {
        $DB_HOST = "15.164.34.2";
        $DB_NAME = "zinzag_DB";
        $DB_USER = "root";
        $DB_PW = "todzmfla#330";
        $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PW);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
}