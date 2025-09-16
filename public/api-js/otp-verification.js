document.addEventListener("DOMContentLoaded", function() {
    const storedEmail = sessionStorage.getItem("login_email");
    if (storedEmail) {
      document.getElementById("email").value = storedEmail;
    } else {
      window.location.href = "{{ url('/login') }}";
    }
  });

    document.getElementById("otpForm").addEventListener("submit", async function (e) {
      e.preventDefault();

      const email = sessionStorage.getItem("login_email");
      const otp = document.getElementById("otp").value;
      let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      let response = await fetch(`${api_url}/verify-otp`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ email, otp })
      });

      let result = await response.json();
      let msgBox = document.getElementById("otpMessage");

      if (response.ok) {
        msgBox.textContent = result.message;
        msgBox.className = "message success";
        setTimeout(() => {
          window.location.href = "{{ url('/index') }}";
        }, 1500);
      } else {
        msgBox.textContent = result.message;
        msgBox.className = "message error";
      }
    });