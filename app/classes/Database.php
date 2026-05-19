<?php
class Database {
    private $host = "eczane-db-service";
    private $db_name;
    private $username = "root";
    private $password;
    public $conn;

    // Singleton örneği
    private static $instance = null;

    // Bağlantıyı başlatan kurucu metod
    private function __construct() {
        // DÜZELTİLDİ: Şifre ve DB adını direkt yazmıyoruz. 
        // K8s Secret'tan gelen ortam değişkenlerini okuyoruz.
        // Eğer bulamazsa (yerel test için) senin eski değerlerini ("EczaneDB", "5270") kullanır.
        $this->db_name = getenv('MYSQL_DATABASE') ? getenv('MYSQL_DATABASE') : "EczaneDB";
        $this->password = getenv('MYSQL_ROOT_PASSWORD') ? getenv('MYSQL_ROOT_PASSWORD') : "5270";

        try {
            // PDO bağlantı cümlesi
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4", $this->username, $this->password);
            
            // Hata modunu aç
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Varsayılan fetch modunu ayarla
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch(PDOException $exception) {
            die("Veritabanı bağlantı hatası: " . $exception->getMessage());
        }
    }

    // Singleton: Tek bir bağlantı oluşturup onu döndürür
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Bağlantı nesnesini dışarıya verir
    public function getConnection() {
        return $this->conn;
    }
}
?>