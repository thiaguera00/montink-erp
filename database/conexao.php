<?php

class Conexao
{
    private static $host;
    private static $db;
    private static $user;
    private static $pass;
    private static $charset = 'utf8mb4';

    public static function conectar()
    {
        require_once __DIR__ . '/../utils/env.php';

        self::$host = $_ENV['DB_HOST'];
        self::$db   = $_ENV['DB_NAME'];
        self::$user = $_ENV['DB_USER'];
        self::$pass = $_ENV['DB_PASS'];

        try {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=" . self::$charset;
            $opcoes = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => false
            ];

            return new PDO($dsn, self::$user, self::$pass, $opcoes);
        } catch (PDOException $e) {
            die('Erro na conexão: ' . $e->getMessage());
        }
    }
}
