<form method="post" id="sifreSifirlamaFormu">
    <label for="email">E-posta Adresi:</label>
    <input type="email" name="email" id="email" required>
    <button type="submit">Şifremi Sıfırla</button>
    <p id="hataMesaji" style="color: red;"></p>
</form>

<script>
    document.getElementById('sifreSifirlamaFormu').addEventListener('submit', function(event) {
        var email = document.getElementById('email').value;
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(email)) {
            document.getElementById('hataMesaji').textContent = "Lütfen geçerli bir e-posta adresi girin.";
            event.preventDefault(); // Formun gönderilmesini engelle
        } else {
            document.getElementById('hataMesaji').textContent = ""; // Hata mesajını temizle
        }
    });
</script>