function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                icon.textContent = "👁️";
            } else {
                input.type = "password";
                icon.textContent = "🙈";
            }
        }

        document.getElementById("loginForm").addEventListener("submit", async function (e) {
            e.preventDefault();

            let formData = {
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
            };
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                let response = await fetch(`${api_url}/login`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(formData)
                });

                let result = await response.json();
                console.log('fetch Successfully');
                let messageBox = document.getElementById('loginmessage');

                if (response.ok) {
                    messageBox.textContent = result.message;
                    messageBox.className = "text-success";
                    sessionStorage.setItem("login_email",formData.email);
                    setTimeout(() => {
                        window.location.href = "{{ url('/otp') }}";
                    }, 1200);
                } else {
                    messageBox.textContent = result.message || "Invalid credentials";
                    messageBox.className = "text-danger";
                }
            } catch (error) {
                document.getElementById("loginmessage").textContent = "Error: " + error.message;
                document.getElementById("loginmessage").className = "text-danger";
            }
        });