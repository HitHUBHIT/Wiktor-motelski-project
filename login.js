document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    fetch('login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ email, password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.href = "index.html"; // Przekierowanie po zalogowaniu
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error("Błąd:", error));
});
