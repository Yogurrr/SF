<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SF</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="https://static.nid.naver.com/js/naverLogin_implicit-1.0.2.js" charset="utf-8"></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <div id="main" class="container mt-3">
        <div class="row soupLogo justify-content-center fw-bold"
            style="color: gold; font-size: 150px; margin-top: 17%;">스프</div>
        <div class="row soupDescription justify-content-center" style="font-size: 25px;">일정 관리와 투두 리스트를 한 번에,</div>
        <p class="justify-content-center text-center soupDescription" style="font-size: 25px;">
            당신의 스케줄 프렌드
            <span style="color: gold;">스프</span>
            <img src="/image/soup.png" alt="" style="width: 2.7%;" class="pt-0 mt-0">
        </p>
        <div id="btnDiv">
            <div class="row mt-2">
                <button type="button" class="offset-4 col-4 btn fw-bold" style="background-color: gold; font-size: 18px;"
                    data-bs-toggle="modal" data-bs-target="#soupLoginModal">스프 아이디로 로그인</button>
            </div>
            <div class="row mt-2">
                <a href="{{ route('google.redirect') }}" class="offset-4 col-4 fw-bold btn btn-outline-primary 
                    d-flex align-items-center justify-content-center" style="font-size: 18px;">
                    <img src="/image/google.png" alt="" style="width: 5%; height: auto;">&nbsp;구글 아이디로 로그인
                </a>
            </div>
            <div class="row mt-2">
                <a href="{{ route('naver.redirect') }}" class="offset-4 col-4 fw-bold btn btn-outline-success 
                    d-flex align-items-center justify-content-center" style="font-size: 18px;">
                    <img src="/image/letter-n.png" alt="" style="width: 5%; height: auto;">&nbsp;네이버 아이디로 로그인
                </a>
            </div>
        </div>
    </div>
</body>

<!-- 스프 아이디 로그인 -->
<div class="modal fade" id="soupLoginModal" tabindex="-1" aria-labelledby="soupLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 400px;">
        <div class="modal-content" style="height: 450px;">
            <div class="modal-header row ms-0 me-0">
                <div class="text-center fs-5 fw-bold">스프 아이디로 로그인</div>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('login.perform') }}">
                    @csrf

                    <div class="row ms-2" style="margin-top: 20%">
                        <label class="col-4 text-end fs-5" for="userid">아이디</label>
                        <input class="col-6" id="userid" type="text" name="userid"
                            style="border-top: none; border-left: none; border-right: none;" required autofocus></input>
                        @if ($errors->has('userid'))
                        <span class="text-danger">{{ $errors->first('userid') }}</span>
                        @endif
                    </div>
                    <div class="row ms-2 mt-4">
                        <label class="col-4 text-end fs-5" for="password">비밀번호</label>
                        <input class="col-6" id="password" type="password" name="password"
                            style="border-top: none; border-left: none; border-right: none;"></input>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="row mt-4">
                        <a href="/find-userid" class="col-auto offset-1 text-dark" style="text-decoration: none;">아이디 찾기</a>
                        <a href="/find-password" class="col-auto text-dark" style="text-decoration: none;">비밀번호 찾기</a>
                        <a href="/join" class="col-auto text-dark" style="text-decoration: none;">회원가입</a>
                    </div>
                    <div class="row mb-4" style="margin-top: 25%;">
                        <button type="submit" class="btn btn-warning offset-3 col-3 me-1 fw-bold">확인</button>
                        <button type="button" class="btn btn-secondary col-3 ms-1 fw-bold"
                            data-bs-dismiss="modal">취소</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    
</script>

<style>
    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translate3d(0, 100%, 0);
        }

        to {
            opacity: 1;
            transform: translateZ(0);
        }
    }

    .soupDescription {
        animation: fadeInUp 1s;
    }

    #btnDiv {
        animation: fadeInUp 3s;
    }
</style>

</html>