window.onload = function () {

    document.getElementById('form-login').onsubmit = function () {
        event.preventDefault();
        let token = document.getElementsByName('_token')[0].value;
        let email = document.getElementsByName('email')[0].value;
        let pass = document.getElementsByName('password')[0].value;
        fetch(url + '/login', {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": token
            },
            method: 'post',
            credentials: "same-origin",
            body: JSON.stringify({
                email: email,
                password: pass
            })
        })
            .then((data) => {
                let main = document.getElementsByTagName('main')[0];
                if (data.ok) {
                    main.classList = login.classList = 'success';
                    setTimeout(function () {
                    }, 900);
                    window.location.href = data.url;
                } else {
                    let login = document.getElementById('login');
                    let form = document.getElementById('form-login');
                    main.classList = login.classList = 'error';
                    let message = document.getElementsByClassName('info-box');
                    message[0].style.visibility = 'unset';

                }
            })
            .catch(function (error) {
                let main = document.getElementsByTagName('main')[0];
                let login = document.getElementById('login');
                main.classList = login.classList = 'error';

            });
    }

    document.getElementById('email').addEventListener("keyup", function(evt)  {
      let main = document.getElementsByTagName('main')[0];
      let login = document.getElementById('login');
      main.classList = login.classList = '';
      let message = document.getElementsByClassName('info-box');
      message[0].style.visibility = 'hidden';
    });

}
