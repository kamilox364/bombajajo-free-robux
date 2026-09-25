<?php
// Konfiguracja połączenia z bazą danych
$host = 'localhost';
$user = 'root';
$pass = ''; // tutaj wpisz hasło do bazy, jeśli takie posiadasz
$db   = 'formularz_db';

$komunikat = '';
$sukces = false;

// Obsługa wysłania formularza
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobranie i oczyszczenie danych z formularza
    $imie        = trim($_POST['imie'] ?? '');
    $drugie_imie = trim($_POST['drugie_imie'] ?? '');
    $nazwisko    = trim($_POST['nazwisko'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $telefon     = trim($_POST['telefon'] ?? '');
    $adres       = trim($_POST['adres'] ?? '');
    $pesel       = trim($_POST['pesel'] ?? '');
    $wiek        = intval($_POST['wiek'] ?? 0);

    // Prosta walidacja
    if (empty($imie) || empty($nazwisko) || empty($email) || empty($telefon) || empty($adres) || empty($pesel) || $wiek <= 0) {
        $komunikat = "Wypełnij wszystkie wymagane pola poprawnie!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $komunikat = "Podany adres e-mail jest nieprawidłowy!";
    } elseif (strlen($pesel) !== 11 || !ctype_digit($pesel)) {
        $komunikat = "PESEL musi składać się dokładnie z 11 cyfr!";
    } else {
        // Połączenie z bazą przez PDO
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO uzytkownicy (imie, drugie_imie, nazwisko, email, telefon, adres, pesel, wiek) 
                    VALUES (:imie, :drugie_imie, :nazwisko, :email, :telefon, :adres, :pesel, :wiek)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':imie'        => $imie,
                ':drugie_imie' => $drugie_imie,
                ':nazwisko'    => $nazwisko,
                ':email'       => $email,
                ':telefon'     => $telefon,
                ':adres'       => $adres,
                ':pesel'       => $pesel,
                ':wiek'        => $wiek
            ]);

            $sukces = true;
            $komunikat = "Dane zostały pomyślnie zapisane w bazie danych!";
        } catch (PDOException $e) {
            $komunikat = "Błąd bazy danych: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FREE ROBUX</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 600;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }
        input:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>FREE ROBUX</h2>

    <?php if (!empty($komunikat)): ?>
        <div class="alert <?php echo $sukces ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($komunikat); ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="imie">Imię *</label>
            <input type="text" id="imie" name="imie" required value="<?php echo htmlspecialchars($_POST['imie'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="drugie_imie">Drugie imię</label>
            <input type="text" id="drugie_imie" name="drugie_imie" value="<?php echo htmlspecialchars($_POST['drugie_imie'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="nazwisko">Nazwisko *</label>
            <input type="text" id="nazwisko" name="nazwisko" required value="<?php echo htmlspecialchars($_POST['nazwisko'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="email">E-mail *</label>
            <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="telefon">Numer telefonu *</label>
            <input type="tel" id="telefon" name="telefon" required value="<?php echo htmlspecialchars($_POST['telefon'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="adres">Adres zamieszkania *</label>
            <textarea id="adres" name="adres" rows="3" required><?php echo htmlspecialchars($_POST['adres'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <label for="pesel">PESEL *</label>
            <input type="text" id="pesel" name="pesel" maxlength="11" required value="<?php echo htmlspecialchars($_POST['pesel'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="wiek">Wiek *</label>
            <input type="number" id="wiek" name="wiek" min="1" max="120" required value="<?php echo htmlspecialchars($_POST['wiek'] ?? ''); ?>">
        </div>

        <button type="submit">Wyślij dane</button>
    </form>
</div>

</body>
</html>