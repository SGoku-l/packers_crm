<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        /* ====== Background ====== */
        body {
            font-family: "Poppins", sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #74ebd5 0%, #9face6 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* ====== Glassy Form Box ====== */
        .form-box {
            background: rgba(255, 255, 255, 0.15);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0px 8px 32px rgba(0, 0, 0, 0.2);
            width: 420px;
            max-width: 95%;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
        }

        .form-box h2 {
            margin-bottom: 25px;
            font-size: 26px;
            font-weight: 600;
            color: #fff;
        }

        /* ====== Inputs ====== */
        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group input {
            width: 100%;
            padding: 16px 50px 16px 16px;
            border: none;
            border-radius: 12px;
            outline: none;
            font-size: 16px;
            color: #333;
            background: rgba(255, 255, 255, 0.9);
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            background: #fff;
            box-shadow: 0px 0px 10px rgba(74, 144, 226, 0.5);
        }

        /* ====== Password Toggle Icon ====== */
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 16px;
            transform: translateY(-50%);
            cursor: pointer;
            user-select: none;
            font-size: 18px;
        }

        /* ====== Button ====== */
        button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #4a90e2, #357ABD);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: linear-gradient(135deg, #357ABD, #2b5aa3);
        }

        /* ====== Responsive (Mobile) ====== */
        @media (max-width: 480px) {
            .form-box {
                padding: 25px;
                border-radius: 15px;
            }

            .form-box h2 {
                font-size: 22px;
            }

            .form-group input {
                padding: 14px 45px 14px 14px;
                font-size: 15px;
            }

            button {
                padding: 14px;
                font-size: 15px;
            }
        }
    </style>
</head>

<body>

    <div class="form-box">
        <h2>Login to Your Account</h2>

        @if ($errors->any())
            <div style="color: #ffdddd; background: rgba(255, 0, 0, 0.2); padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form id="loginForm">
            @csrf
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required id='email'>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required id="password">
                <span class="toggle-password" onclick="togglePassword('password', this)">🙈</span>
            </div>

            <button type="submit">Login</button>
        </form>
        <div id="loginmessage"></div>
    </div>

    <script>
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

            const api_url = "{{ config('app.api_url') }}";

            try {
                let response = await fetch(`${api_url}/login`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(formData)
                });

                let result = await response.json();
                let messageBox = document.getElementById('loginmessage');

                if (response.ok) {
                    messageBox.textContent = result.message;
                    messageBox.className = "message success";
                    setTimeout(() => {
                        window.location.href = result.redirect_url;
                    }, 1200);
                } else {
                    messageBox.textContent = result.message || "Invalid credentials";
                    messageBox.className = "message error";
                }
            } catch (error) {
                document.getElementById("loginmessage").textContent = "Error: " + error.message;
                document.getElementById("loginmessage").className = "message error";
            }
        });

    </script>

</body>
</html>
