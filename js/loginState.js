function ensureLogin() {
    var type = $.cookie('type');
    var token = $.cookie('token');
    var uid = $.cookie('uid');
    swal({
        title: "载入中",
        width: 250,
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        onOpen: () => {
            swal.showLoading()
        }
    });
    $.post("../../api/account/loginState.php", {
        type: type,
        token: token,
        uid: uid
    }).done((data) => {
        data = JSON.parse(data);
        if (data.validity == 1) {
            swal.close();
        } else {
            let timerInterval;
            swal({
                title: '请登录',
                html: '页面将于 <strong></strong> 秒后跳转至登陆页面。',
                timer: 5500,
                onOpen: () => {
                    swal.showLoading()
                    timerInterval = setInterval(() => {
                        swal.getContent().querySelector('strong')
                            .textContent = parseInt((swal.getTimerLeft()) / 1000)
                    }, 100)
                },
                onClose: () => {
                    clearInterval(timerInterval)
                }
            }).then(() => {
                window.location.href = "../login.html";
            })
        }
    })
}