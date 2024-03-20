@extends('layouts.guest-layouts')
@section('content')
<main>
    <div class="row" style="margin-top: 10%;">
        <div class="card offset-3 col-6 p-0">
            <h3 class="card-header text-center" style="background-color: palegoldenrod;">비밀번호 찾기</h3>
            <div class="card-body">
                <form>
                    @csrf
                    <div class="mb-3">가입한 이메일을 입력하면 임시 비밀번호를 보내드립니다.</div>
                    <div class="form-group mb-3">
                        <input type="text" placeholder="이름" id="name" class="form-control" name="name" required
                            autofocus>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" placeholder="아이디" id="userid" class="form-control" name="userid" required
                            autofocus>
                    </div>
                    <div class="form-group mb-3">
                        <input type="email" placeholder="이메일" id="email" class="form-control" name="email"
                            required autofocus>
                    </div>
                    <div class="d-grid mx-auto">
                        <button type="button" class="btn btn-block fw-bold" style="background-color: palegoldenrod;"
                            id="confirm_btn">확인</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="alert alert-success col-6 offset-3 mt-3 fw-bold text-center" role="alert" id="alert"
            style="display: none;">
            <div id="message" style="font-size: 17px;"></div>
        </div>
    </div>
</main>



<script>
    let alert = document.querySelector("#alert");
    let message = document.querySelector("#message");

    let confirm_btn = document.querySelector("#confirm_btn");

    let generate_temporary_password = () => {
        let characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';
        let charactersLength = characters.length;
        for (let i = 0; i < 15; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }

        return result;
    }

    confirm_btn.addEventListener('click', () => {
        let name = document.querySelector('#name').value.trim();
        let userid = document.querySelector('#userid').value.trim();
        let email = document.querySelector('#email').value.trim();

        fetch('/membershipPresence', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                name: name,
                userid: userid,
                email: email
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            let temporary_pswd = generate_temporary_password();
            console.log('tp : ' + temporary_pswd);

            confirm_btn.disabled = true;
                
            fetch('/updateTemporaryPassword', {
                method: 'POST',
                headers: {
                    'Content-Type' : 'application/json',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    userid: userid,
                    temporary_pswd: temporary_pswd,
                    name: name,
                    email: email,
                })
            })
            .then(response => {
                if(!response.ok) {
                    throw new Error('Network response was not ok')
                } else {
                    return response.json();
                }
            })
            .then(data => {
                alert.style.display = "block";
                alert.classList.remove("alert-danger");
                alert.classList.add("alert-success");
                message.innerText = "임시 비밀번호가 발송되었습니다. 이메일을 확인해주세요.";
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation 1 :', error);
            })
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation 2 :', error);
            alert.style.display = "block";
            alert.classList.remove("alert-warning");
            alert.classList.add("alert-danger");
            message.innerText = "입력하신 정보가 회원정보에 존재하지 않습니다.";

            let name_input = document.querySelector('#name');
            let userid_input = document.querySelector('#userid');
            let email_input = document.querySelector('#email');

            setTimeout(function() {
                name_input.value = '';
                userid_input.value = '';
                email_input.value = '';
            }, 2000);
        });
    });
</script>

<style>

</style>
@endsection