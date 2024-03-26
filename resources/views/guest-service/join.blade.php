@extends('layouts.guest-layouts')
@section('content')
<main>
    <div class="row" style="margin-top: 10%;">
        <div class="card offset-3 col-6 p-0">
            <h3 class="card-header text-center" style="background-color: palegoldenrod;">회원가입</h3>
            <div class="card-body">
                <form action="{{ route('join.perform') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <div class="floating-label-group">
                            <input type="text" id="name" class="form-control" name="name" required autofocus maxlength="10">
                            <label class="floating-label">이름</label>
                        </div>
                        @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <div class="floating-label-group">
                            <input type="text" id="userid" class="form-control" name="userid" required autofocus maxlength="20">
                            <label class="floating-label">ID</label>
                        </div>
                        <div class="mt-2 row">
                            <button type="button" class="rounded col-auto ms-3" style="background-color: palegoldenrod; 
                                border: 1px solid palegoldenrod; font-size: 15px;" id="chk_dup_btn" disabled>ID 중복 확인</button>
                            <div class="col-auto fw-bold d-flex align-items-center" id="dup_message"></div>
                        </div>
                        @if ($errors->has('userid'))
                        <span class="text-danger">{{ $errors->first('userid') }}</span>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <div class="floating-label-group">
                            <input type="password" id="password" class="form-control" name="password" required maxlength="20">
                            <label class="floating-label">비밀번호</label>
                        </div>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <div class="floating-label-group">
                            <input type="email" id="email_address" class="form-control" name="email" required autofocus maxlength="50">
                            <label class="floating-label">이메일</label>
                        </div>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="alert alert-danger fw-bold" role="alert" id="join_alert" style="display: none;"></div>
                    <div class="d-grid mx-auto mt-4">
                        <button type="submit" class="btn btn-block fw-bold" style="background-color: palegoldenrod;" id="join_btn" disabled>가입</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>



<script>
    let join_alert = document.querySelector('#join_alert');
    let join_btn = document.querySelector('#join_btn');
    let chk_dup_btn = document.querySelector('#chk_dup_btn');
    let dup_message = document.querySelector('#dup_message');

    let ko_regex = /[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]+$/;
    let uid_regex = /^[\w|\-]+$/;
    let pswd_regex = /^[\w\!\@\#\$\%\^\&\*\+\=\?]+$/;
    let email_regex = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;

    // 이름
    let name = document.querySelector('#name');
    name.addEventListener('focusout', () => {
        if(!ko_regex.test(name.value) && name.value !== '') {
            name.style.border = '1px solid coral';
            join_alert.style.display = 'block';
            join_alert.innerText = '이름에는 10자 이하의 한글만 입력할 수 있습니다.';
        } else {
            join_alert.style.display = 'none';
            name.style.border = '';
        }

        if(name.value !== '' && userid.value !== '' && password.value !== '' && email_address.value !== '') {
            join_btn.disabled = false;
        }
    });

    // 아이디
    let userid = document.querySelector('#userid');
    userid.addEventListener('focusout', () => {
        console.log('length: ' + userid.value.length);
        if((!uid_regex.test(userid.value) && userid.value !== '') || userid.value.length < 5 ) {
            userid.style.border = '1px solid coral';
            join_alert.style.display = 'block';
            join_alert.innerText = '아이디에는 5~20자의 영문 소문자, 숫자와 특수기호(_),(-)만 입력할 수 있습니다.';
            chk_dup_btn.disabled = true;
        } else {
            join_alert.style.display = 'none';
            userid.style.border = '';
            chk_dup_btn.disabled = false;
        }

        if(name.value !== '' && userid.value !== '' && password.value !== '' && email_address.value !== '') {
            join_btn.disabled = false;
        }
    });

    // 비밀번호
    let password = document.querySelector('#password');
    password.addEventListener('focusout', () => {
        if(!pswd_regex.test(password.value) && password.value !== '' && password.value.length < 8) {
            password.style.border = '1px solid coral';
            join_alert.style.display = 'block';
            join_alert.innerText = '비밀번호는 8~20자 영문, 숫자, 특수문자(!,@,#,$,%,^,&,*,-,_,+,=,?) 이상으로 조합해주세요.';
            dup_message = '';
        } else {
            join_alert.style.display = 'none';
            password.style.border = '';
        }
        
        if(name.value !== '' && userid.value !== '' && password.value !== '' && email_address.value !== '') {
            join_btn.disabled = false;
        }
    });

    // 이메일
    let email_address = document.querySelector('#email_address');
    email_address.addEventListener('focusout', () => {
        if(!email_regex.test(email_address.value) && email_address.value !== '') {
            email_address.style.border = '1px solid coral';
            join_alert.style.display = 'block';
            join_alert.innerText = '이메일 형식이 올바르지 않습니다.';
        } else {
            join_alert.style.display = 'none';
            email_address.style.border = '';
        }

        if(name.value !== '' && userid.value !== '' && password.value !== '' && email_address.value !== '') {
            join_btn.disabled = false;
        }
    });

    // 아이디 중복 확인
    chk_dup_btn.addEventListener('click', () => {
        let userid_value = userid.value;

        fetch('/checkIdDuplication', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ userid_value: userid_value })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if(data.id) {
                console.log('data: ' + data.id);
                dup_message.innerText = '이미 존재하는 아이디입니다.';
                dup_message.style.color = 'firebrick';
            } else {
                console.log('message: ' + data.message);
                dup_message.innerText = '사용 가능한 아이디입니다.';
                dup_message.style.color = 'royalblue';
            }
        })
        .catch(error => console.error('Error:', error));
    });

    
</script>

<style>
    .form-control {
        height: 50px;
        font-size: 18px;
    }

    .floating-label-group {
    	position: relative;
    	/* margin-top: 15px; */
    	margin-top: 32px;
    	/* margin-bottom: 25px; */

    	.floating-label {
    		font-size: 18px;
    		color: grey;
    		position: absolute;
    		pointer-events: none;
    		top: 9px;
    		left: 12px;
    		transition: all 0.1s ease;
    	}

    	input:focus ~ .floating-label,
    	input:not(:focus):valid ~ .floating-label {
    		top: -25px;
    		bottom: 0px;
    		left: 0px;
    		font-size: 15px;
    		opacity: 1;
    		color: #404040;
    	}
    }
</style>
@endsection