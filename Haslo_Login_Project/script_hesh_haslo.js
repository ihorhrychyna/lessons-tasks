async function hashPassword() {
    const passwordInput = document.getElementById("password").value;

    if (!passwordInput) {
      alert("Wprowadź hasło przed zahaszowaniem.");
      return;
    }

    const encoder = new TextEncoder();
    const data = encoder.encode(passwordInput);
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashedValue = hashArray.map(byte => byte.toString(16).padStart(2, '0')).join('');

    document.getElementById("result").innerHTML = `Zahaszowane Hasło: ${hashedValue}`;
  }