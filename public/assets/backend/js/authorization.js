
function authorization(path) {
    var login    = document.getElementById('login-auth');
    var password = document.getElementById('password-auth');

    $.ajax({
        type: "POST",
        url: path,
        data: {
            login: login.value,
            password: password.value,
            action: "login"
        },
        success: function(result) {
            let json_data = JSON.parse(result);

            if(json_data.hasOwnProperty('login') && json_data.hasOwnProperty('error_code')){
                console.log(json_data['login']);
    
                let elem_advice = document.getElementById("advice");
                let elem_status = document.getElementById("status");
                let hidden = elem_status.getAttribute("hidden");
                if (hidden) elem_status.removeAttribute("hidden");
                
                $msg = "";
                $advice = "";
                switch(json_data['error_code']){
                    case 0: // UNBLOCKPROFILE;
                        $msg = "Профиль разблокирован";
                        $advice = "Осуществляется переход в профиль.";
                        window.top.location.href = json_data['url'];
                        break;
                    case 1: // BLOCK_PROFILE
                        $msg = "Профиль с такими данными обнаружен, но заблокирован!";
                        $advice = "Попробуйте обратиться в тех. поддержку.";
                        break;
                    case 2: // PASSWORD;
                        $msg = "Не верный пароль!";
                        $advice = "Попробуйте обратиться в тех. поддержку.";
                        break;
                    case 3:
                        $msg = "3.1";
                        $advice = "3.2";
                        break;
                }
    
                //if(json_data['error_code']){ 
                    elem_status.textContent = $msg;
                    elem_advice.textContent = $advice;
                //}
            }
        }
    });
}

function close_authorization_registration() {
    window.parent.close_iframe();
}

// Смена страницы!
function next_form($path) { 
    window.parent.change_size_iframe(window.name, 0, 80);
    window.location.replace($path);
}

