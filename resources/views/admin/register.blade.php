<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Glassy Register Form</title>
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

    /* ====== Toggle Eye / Monkey Button ====== */
    .toggle-password {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
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
    <h2>Register</h2>
<form id="registerForm">   

    <div class="form-group">
      <input type="text" placeholder="Enter Name" id="name">
    </div>
    <div class="form-group">
      <input type="email" placeholder="Enter Email" id="email"> 
    </div>
    <div class="form-group">
      <input type="tel" placeholder="Enter Phone Number" id="phone">
    </div>
    <div class="form-group">
      <input type="password" placeholder="Enter Password" id="password">
      <span class="toggle-password" onclick="togglePassword('password', this)">🙈</span>
    </div>
    <div class="form-group">
      <input type="password" placeholder="Confirm Password" id="password_confirmation">
      <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">🙉</span>
    </div>
    <button type="submit">Register</button>

</form>

    <div id="registermessage"></div>
  </div>

<script>

    function togglePassword(fieldId, icon) {
    let field = document.getElementById(fieldId);
    if (field.type === "password") {
        field.type = "text";
        icon.textContent = "🐵";  // password visible
    } else {
        field.type = "password";
        icon.textContent = "🙈";  // password hidden
    }
    }
 document.getElementById("registerForm").addEventListener("submit", async function (e) {
     e.preventDefault(); 

     let formdata = { 
        name: document.getElementById('name').value, 
        email: document.getElementById('email').value, 
        phone: document.getElementById('phone').value, 
        password: document.getElementById('password').value, 
        password_confirmation: document.getElementById('password_confirmation').value, 
        }; 
        const api_url = "{{ config('app.api_url') }}"; 

        try { 
            let response = await fetch(`${api_url}/register`, 
            { 
                method: "POST", 
                headers: { 
                    "Content-Type": "application/json", 
                    "Accept": "application/json", 
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" 
                }, 
                    body: JSON.stringify(formdata) 
            }); 
            let result = await response.json(); 
            let messageBox = document.getElementById("registermessage");

            if (response.ok) { 
                messageBox.textContent = result.message; 
                messageBox.className = "message success";

                setTimeout(() => {
                window.location.href = "{{ url('/otp') }}?phone=" + encodeURIComponent(formdata.phone);
            }, 1200);

            } else { 
                if (result.errors) { 
                    let errors = Object.values(result.errors).flat().join(", "); 
                    messageBox.textContent = errors; 
                } else { 
                    messageBox.textContent = result.message || "Something went wrong!"; 
                } messageBox.className = "message error"; 
            } 
        } catch (error) { 
            document.getElementById("registermessage").textContent = "Error: " + error.message; 
            document.getElementById("registermessage").className = "message error"; 
        }
    }); 
</script>
</body>
</html>
