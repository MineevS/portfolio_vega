
function registr(path) {
    var      login_reg = document.getElementById('login-reg');
    var  firstname_reg = document.getElementById('firstname-reg');
    var   lastname_reg = document.getElementById('lastname-reg');
    var patronymic_reg = document.getElementById('patronymic-reg');
    var      email_reg = document.getElementById('email-reg');
    var  telephone_reg = document.getElementById('telephone-reg');
    var   password_reg = document.getElementById('password-reg');

    var data = function() {
        return $.ajax({
            type: "POST",
            url: path, 
            data: {
                login: login_reg.value,
                password: password_reg.value,
                firstname: firstname_reg.value,
                lastname: lastname_reg.value,
                patronymic: patronymic_reg.value,
                email: email_reg.value,
                telephone: telephone_reg.value,
                action: "registr"
            }
        });
    }
       
    data().then(function(result) {
        console.log(result);

        let json_data = JSON.parse(result); // eval();

        if(json_data.hasOwnProperty('register') && json_data.hasOwnProperty('error_code')){
            console.log(json_data['register']);

            let elem_status = document.getElementById("status");
            let hidden = elem_status.getAttribute("hidden");

            let elem_advice = document.getElementById("advice");
            
            if (hidden) {
                elem_status.removeAttribute("hidden");
            } else {
               //elem_status.setAttribute("hidden", "hidden");
            }

            $msg = "";
            $advice = "";
            switch(json_data['error_code']){
                case 0:
                    $msg = "Вы успешно зарегистрированны в системе.";
                    $advice = "Ожидайте подтверждения учетной записи пользователя сайта модератором.";
                    break;
                case 1:
                    $msg = "1.1";
                    $advice = "1.2";
                    break;
                case 2:
                    $msg = "В системе уже зарегестрирован пользователь с таким логином.";
                    $advice = "Попробуйте войти или зарегестрироваться под новым логином.";
                    break;
                case 3:
                    $msg = "3.1";
                    $advice = "3.2";
                    break;
            }

            elem_status.textContent = $msg;
            elem_advice.textContent = $advice;
        }
    });
}

function close_registration() { 
    window.parent.close_iframe();
}

function prev_form(page) {
    window.location.replace(page); 
    window.parent.change_size_iframe(window.name, 0, 50);
}

