@extends('layouts.guest-layouts')
@section('content')
<main>
    <div class="row" style="margin-top: 10%;">
        <div class="card offset-3 col-6 p-0">
            <h3 class="card-header text-center" style="background-color: palegoldenrod;">아이디 찾기</h3>
            <div class="card-body">
                <form>
                    @csrf
                    <div class="form-group mb-3">
                        <input type="text" placeholder="이름" id="name" class="form-control" name="name" required
                            autofocus>
                    </div>
                    <div class="form-group mb-3">
                        <input type="email" placeholder="이메일" id="email_address" class="form-control" name="email"
                            required autofocus>
                    </div>
                    <div class="d-grid mx-auto">
                        <button type="button" class="btn btn-block fw-bold" style="background-color: palegoldenrod;"
                            id="confirmBtn">확인</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="alert alert-warning col-6 offset-3 mt-3 fw-bold text-center" role="alert" id="alert"
            style="display: none;">
            <div id="message" style="font-size: 17px;"></div>
        </div>
    </div>
</main>



<script>
    let name = document.querySelector("#name");
    let email = document.querySelector("#email_address");
    
    let alert = document.querySelector("#alert");
    let message = document.querySelector("#message");

    let confirmBtn = document.querySelector("#confirmBtn");

    confirmBtn.addEventListener('click', () => {
        var httpRequest;
        let nameValue = name.value;
        let emailValue = email.value;
        httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = () => {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                if (httpRequest.status === 200) {
                    let result = httpRequest.response;

                    alert.style.display = "block";
                    alert.classList.remove("alert-danger");
                    alert.classList.add("alert-warning");
                    message.innerText = "회원님의 ID는 [" + result.userid + '] 입니다.';
                } else if(httpRequest.status === 404) {
                    let result = httpRequest.response;

                    alert.style.display = "block";
                    alert.classList.remove("alert-warning");
                    alert.classList.add("alert-danger");
                    message.innerText = "일치하는 아이디가 없습니다.";

                    setTimeout(function() {
                        name.value = "";
                        email.value = "";
                    }, 2000);
                } else {
                    alert('Request Error!');
                }
            }
        };
        httpRequest.open('GET', '/getUseridByEmail?nameValue=' + nameValue + '&emailValue=' + emailValue);
        httpRequest.responseType = "json";
        httpRequest.send();
    });
</script>

<style>

</style>
@endsection