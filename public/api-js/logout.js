document.getElementById("logoutForm").addEventListener("click",async function (e) {
            e.preventDefault();
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            try{
                let response = await fetch(`${api_url}/logout`,{
                    method : 'POST',
                    headers : {
                        'Content-Type' : 'application/json',
                        'Accept' : 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                 let result = await response.json();

                 if(response.ok){
                    window.location.href = login_url;
                 }else{
                    alert(result.message || "Logout failed!");
                 }
            }catch (error) {
                alert("Error: " + error.message);
            }
        });