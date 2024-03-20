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
                        <input type="text" placeholder="이름" id="name" class="form-control" name="name" required
                            autofocus>
                        @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" placeholder="아이디" id="userid" class="form-control" name="userid" required
                            autofocus>
                        @if ($errors->has('userid'))
                        <span class="text-danger">{{ $errors->first('userid') }}</span>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" placeholder="비밀번호" id="password" class="form-control" name="password"
                            required>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <input type="email" placeholder="이메일" id="email_address" class="form-control" name="email"
                            required autofocus>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="d-grid mx-auto">
                        <button type="submit" class="btn btn-block fw-bold" style="background-color: palegoldenrod;">가입</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>



<script>
    //
</script>

<style>

</style>
@endsection