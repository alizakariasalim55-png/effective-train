[21:36, 23/11/2026] Kallimi: <?php
header('Content-Type: application/json; charset=utf-8');

// ====== Configuration base de données ======
$host = 'localhost';
$db   = 'monsite';
$user = 'root';
$pass = '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['succes' => false, 'message' => 'Méthode non autorisée.']);
    exit;
}

$nom     = trim($_POST['nom'] ?? '');
$email   = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($nom === '' || $email === '' || $message === '') {
    echo json_encode(['succes' => false, 'message' => 'Tous les champs sont obligatoires.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['succes' => false, 'message' => 'Adresse email invalide.']);
    exit;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO messages (nom, email, message) VALUES (:nom, :email, :message)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom'     => $nom,
        ':email'   => $email,
        ':message' => $message
    ]);

    echo json_encode(['succes' => true, 'message' => 'Message envoyer avec succes !']);
} catch (PDOException $e) {
    echo json_encode(['succes' => false, 'message' => 'Erreur serveur, reessayez plus tard.']);
}