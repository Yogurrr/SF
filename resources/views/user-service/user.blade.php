@extends('layouts.app-layouts')
@section('content')
<main>
    <h2><span class="badge rounded-pill text-dark" style="background-color: gold">프로필</span></h2>

    <div class="card mt-3">
        <div class="card-header">기본 정보</div>
        <div class="card-body" id="user_info">
            <div>이름 : {{ Auth::user()->name }}</div>
            <div>아이디 : {{ Auth::user()->userid }}</div>
            <div>이메일 : {{ Auth::user()->email }}</div>
        </div>
    </div>

    <div class="card mt-3" id="pswd_update_card">
        <div class="card-header">비밀번호 수정</div>
        <form method="post" action="{{ route('update-password') }}" class="mt-6 space-y-6">
            @csrf
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @elseif (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif
                <div class="mb-3">
                    <div><label for="current_password" class="form-label mb-0">현재 비밀번호</label></div>
                    <div>
                        <input id="current_password" name="current_password" type="password" class="form-control border-2"
                            autocomplete="current-password"/>
                        @error('current_password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div><label for="password" class="forn-label">새로운 비밀번호</label></div>
                    <div>
                        <input id="password" name="password" type="password" class="form-control border-2 "
                            autocomplete="new-password"/>
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div><label for="password_confirmation" class="form-label mb-0">비밀번호 재확인</label></div>
                    <div>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            class="form-control border-2" autocomplete="new-password"/>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn fw-bold" style="background-color: gold;">저장</button>
            </div>
        </form>
    </div>

    <div class="card mt-3">
        <div class="card-header">투두 달성률 통계</div>
        <div class="card-body mt-2">
            <div class="row">
                <div class="btn-group col-2">
                  <button type="button" class="btn dropdown-toggle fw-bold" id="marked_date_btn"
                        data-bs-toggle="dropdown" aria-expanded="false" style="border: 2px solid palegoldenrod"></button>
                  <ul class="dropdown-menu">
                        <li><a class="dropdown-item fw-bold" href="javascript:void(0);" id="month-0"></a></li>
                        <li><a class="dropdown-item fw-bold" href="javascript:void(0);" id="month-1"></a></li>
                        <li><a class="dropdown-item fw-bold" href="javascript:void(0);" id="month-2"></a></li>
                        <li><a class="dropdown-item fw-bold" href="javascript:void(0);" id="month-3"></a></li>
                        <li><a class="dropdown-item fw-bold" href="javascript:void(0);" id="month-4"></a></li>
                        <li><a class="dropdown-item fw-bold" href="javascript:void(0);" id="month-5"></a></li>
                        <li><a class="dropdown-item fw-bold" href="javascript:void(0);" id="month-6"></a></li>
                        <li><a class="dropdown-item fw-bold" href="javascript:void(0);" id="month-7"></a></li>
                        <li><a class="dropdown-item fw-bold" href="javascript:void(0);" id="month-8"></a></li>
                        <li><a class="dropdown-item fw-bold" href="javascript:void(0);" id="month-9"></a></li>
                        <li><a class="dropdown-item fw-bold" href="javascript:void(0);" id="month-10"></a></li>
                        <li><a class="dropdown-item fw-bold" href="javascript:void(0);" id="month-11"></a></li>
                  </ul>
                </div>
            </div>
            <div class="row mt-3 mb-3">
                <div class="col-5 offset-1">
                    <div class="row" style="height: 43.78px;">
                        <div class="fw-bold d-flex align-items-center justify-content-center" 
                            id="monthly_achievement_rate_title"></div>
                    </div>
                    <div style="width: 70%; height: auto; margin-left: 15%;">
                        <canvas id="monthly_chart"></canvas>
                    </div>
                    <div class="mt-2 text-center fw-bold" id="num_of_monthly_todo"></div>
                </div>
                <div class="col-5">
                    <div class="row">
                        <button class="col-2 btn fs-5 fw-bold" id="backward_btn"><</button>
                        <div class="col-8 fw-bold d-flex align-items-center justify-content-center" 
                            id="weekly_achievement_rate_title"></div>
                        <input type="hidden" id="week_value_storage_input">
                        <button class="col-2 btn fs-5 fw-bold" id="forward_btn">></button>
                    </div>
                    <div style="width: 70%; height: auto; margin-left: 15%;">
                        <canvas id="weekly_chart"></canvas>
                    </div>
                    <div class="mt-2 text-center fw-bold" id="num_of_weekly_todo"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">회원 탈퇴</div>
        <div class="card-body">
            <button class="btn btn-danger fw-bold" data-bs-toggle="modal" type="submit"
                data-bs-target="#confirmDeletionModal" id="acct_del_btn">회원 탈퇴</button>
        </div>
    </div>
</main>

<!-- 계정 삭제 재확인 모달 -->
<div class="modal fade" id="confirmDeletionModal" tabindex="-1" aria-labelledby="confirmDeletionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal-width">
        <div class="modal-content p-4">
            <div class="fs-5 pb-3 fw-bold" style="border-bottom: 1px solid grey;">회원 탈퇴 이전에 아래의 사항을 확인해주세요.</div>
            <div class="mt-1 pt-3 fs-5 row mb-2">
                <div class="col-8 d-flex align-items-center">아이디 복구 불가</div>
                <div class="col-4 d-flex align-items-center justify-content-end">
                    <input type="checkbox" class="form-check-input mt-0" id="unable_to_recover_ID">&nbsp;동의
                </div>
            </div>
            <div class="p-3" style="background-color: whitesmoke;">
                <p class="m-0">회원 탈퇴가 완료되면 이후 <span class="text-danger">아이디 복구는 불가</span>합니다.</p>
            </div>
            <div class="mt-1 pt-3 fs-5 row mb-2">
                <div class="col-8 d-flex align-items-center">사용자 정보 소멸</div>
                <div class="col-4 d-flex align-items-center justify-content-end">
                    <input type="checkbox" class="form-check-input mt-0" id="disappear_user_info">&nbsp;동의
                </div>
            </div>
            <div class="p-3" style="background-color: whitesmoke;">
                고객정보보호 관련법에 따라 회원 탈퇴가 완료되면 회원 정보 및 관련된 모든 정보가 삭제 또는 소멸합니다.
            </div>
            <form action="{{ route('delete-account') }}" method="POST" id="delete_account_form">
                @csrf
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn me-2 fw-bold border border-2" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-danger" id="del_acct_btn" disabled>회원 탈퇴</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // 컨트롤러에서 변수 가져오기
    <?php 
        echo "let raw_todo = " . json_encode($todo) . ";";
    ?>

    // 주차 구하는 함수
    const getWeek = (date) => {
        const currentDate = date.getDate();
        const firstDay = new Date(date.setDate(1)).getDay();

        return Math.ceil((currentDate + firstDay) / 7);
    };

    // 연도-월
    let refined_month = (month) => {
        if(month < 10) {
            return '0' + month;
        } else {
            return month;
        }
    };

    // 오늘자 주차 구하기
    const today = new Date();
    const year_of_today = today.getFullYear();
    const month_of_today = today.getMonth() + 1;
    const week_of_todays_date = getWeek(today);
    
    let marked_date_btn = document.querySelector("#marked_date_btn");
    marked_date_btn.innerText = `${year_of_today}년 ${month_of_today}월`;
    marked_date_btn.value = `${year_of_today}-${refined_month(month_of_today)}`

    let monthly_achievement_rate_title = document.querySelector("#monthly_achievement_rate_title");
    monthly_achievement_rate_title.innerText = `${year_of_today}년 ${month_of_today}월 달성률`;

    let weekly_achievement_rate_title = document.querySelector("#weekly_achievement_rate_title");
    weekly_achievement_rate_title.innerText = `${year_of_today}년 ${month_of_today}월 ${week_of_todays_date}주차 달성률`

    let week_value_storage_input = document.querySelector('#week_value_storage_input');
    week_value_storage_input.value = week_of_todays_date;

    // 월별 달성률 구하기
    let monthly_todo_counts = 0;
    raw_todo.find(mtc => {
        if(mtc.tdate.startsWith(marked_date_btn.value)) {
            monthly_todo_counts++;
        }
    })

    let monthly_checked_todo_counts = 0;
    raw_todo.find(mtct => {
        if(mtct.tdate.startsWith(marked_date_btn.value) && mtct.is_checked === 1) {
            monthly_checked_todo_counts++;
        }
    })
    let monthly_achievement_rate = (monthly_checked_todo_counts * (100 / monthly_todo_counts));

    // 주별 투두 갯수 표시
    let num_of_monthly_todo = document.querySelector('#num_of_monthly_todo');
    num_of_monthly_todo.innerText = `${monthly_checked_todo_counts} / ${monthly_todo_counts}`;

    // 월별 차트
    var monthly_chart = document.getElementById('monthly_chart').getContext('2d');
    var my_monthly_chart = new Chart(monthly_chart, {
        type: 'pie',
        data: {
            labels: ['달성 to-do', '미달성 to-do'],
            datasets: [{
                data: [monthly_achievement_rate, (100 - monthly_achievement_rate)],
                backgroundColor: [
                    'rgba(255, 215, 0, 0.7)',
                    'rgba(128, 128, 128, 0.7)',
                ],
                borderColor: [
                    'rgba(255, 215, 0, 1)',
                    'rgba(128, 128, 128, 1)',
                ],
                borderWidth: 1
            }]
        },
    });

    // 주별 달성률 구하기
    let weekly_todo_counts = 0;
    raw_todo.find(wtc => {
        let converted_date = new Date(wtc.tdate);
        if(wtc.tdate.startsWith(marked_date_btn.value) && getWeek(converted_date) === week_of_todays_date) {
            weekly_todo_counts++;
        }
    })
    let weekly_checked_todo_counts = 0;
    raw_todo.find(wctc => {
        let converted_date = new Date(wctc.tdate);
        if(wctc.tdate.startsWith(marked_date_btn.value) && getWeek(converted_date) === week_of_todays_date && wctc.is_checked === 1) {
            weekly_checked_todo_counts++;
        }
    })
    let weekly_achievement_rate = (weekly_checked_todo_counts * (100 / weekly_todo_counts));

    // 주별 투두 갯수 표시
    let num_of_weekly_todo = document.querySelector('#num_of_weekly_todo');
    num_of_weekly_todo.innerText = `${weekly_checked_todo_counts} / ${weekly_todo_counts}`;

    // 주별 차트
    var weekly_chart = document.getElementById('weekly_chart').getContext('2d');
    var my_weekly_chart = new Chart(weekly_chart, {
        type: 'pie',
        data: {
            labels: ['달성 to-do', '미달성 to-do'],
            datasets: [{
                data: [weekly_achievement_rate, (100 - weekly_achievement_rate)],
                backgroundColor: [
                    'rgba(255, 215, 0, 0.7)',
                    'rgba(128, 128, 128, 0.7)',
                ],
                borderColor: [
                    'rgba(255, 215, 0, 1)',
                    'rgba(128, 128, 128, 1)',
                ],
                borderWidth: 1
            }]
        },
    });

    // 뒤로 가기
    let backward_btn = document.querySelector('#backward_btn');
    backward_btn.addEventListener('click', () => {
        if(week_value_storage_input.value > 1) {
            // 표시되는 날짜 바꾸기
            week_value_storage_input.value = week_value_storage_input.value - 1;

            let formalized_marked_date = new Date(marked_date_btn.value + '-01');
            let year_of_fmd = formalized_marked_date.getFullYear();
            let month_of_fmd = formalized_marked_date.getMonth() + 1;

            weekly_achievement_rate_title.innerText = `${year_of_fmd}년 ${month_of_fmd}월 ${week_value_storage_input.value}주차 달성률`;

            // 표시되는 차트 바꾸기
            weekly_todo_counts = 0;
            raw_todo.find(wtc => {
                let converted_date = new Date(wtc.tdate);
                if(wtc.tdate.startsWith(marked_date_btn.value) && getWeek(converted_date) == week_value_storage_input.value) {
                    weekly_todo_counts++;
                }
            })

            weekly_checked_todo_counts = 0;
            raw_todo.find(wctc => {
                let converted_date = new Date(wctc.tdate);
                if(wctc.tdate.startsWith(marked_date_btn.value) && getWeek(converted_date) == week_value_storage_input.value && wctc.is_checked === 1) {
                    weekly_checked_todo_counts++;
                }
            })

            weekly_achievement_rate = (weekly_checked_todo_counts * (100 / weekly_todo_counts));
            num_of_weekly_todo.innerText = `${weekly_checked_todo_counts} / ${weekly_todo_counts}`;
            my_weekly_chart.data.datasets[0].data = [weekly_achievement_rate, (100 - weekly_achievement_rate)];
            my_weekly_chart.update();
        }
    });

    // 달의 마지막 주차 구하는 함수
    let get_last_week = (date) => {
        let last_day = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
        let first_day = new Date(date.setDate(1)).getDay();

        return Math.ceil((last_day + first_day) / 7);
    };

    // 앞으로 가기
    let forward_btn = document.querySelector('#forward_btn');
    forward_btn.addEventListener('click', () => {
        let week_limit = get_last_week(new Date(marked_date_btn.value + '-01'));
        if(week_value_storage_input.value < week_limit) {
            // 표시되는 날짜 바꾸기
            week_value_storage_input.value = +week_value_storage_input.value + 1;

            let formalized_marked_date = new Date(marked_date_btn.value + '-01');
            let year_of_fmd = formalized_marked_date.getFullYear();
            let month_of_fmd = formalized_marked_date.getMonth() + 1;

            weekly_achievement_rate_title.innerText = `${year_of_fmd}년 ${month_of_fmd}월 ${week_value_storage_input.value}주차 달성률`;

            // 표시되는 차트 바꾸기
            weekly_todo_counts = 0;
            raw_todo.find(wtc => {
                let converted_date = new Date(wtc.tdate);
                if(wtc.tdate.startsWith(marked_date_btn.value) && getWeek(converted_date) == week_value_storage_input.value) {
                    weekly_todo_counts++;
                }
            })

            weekly_checked_todo_counts = 0;
            raw_todo.find(wctc => {
                let converted_date = new Date(wctc.tdate);
                if(wctc.tdate.startsWith(marked_date_btn.value) && getWeek(converted_date) == week_value_storage_input.value && wctc.is_checked === 1) {
                    weekly_checked_todo_counts++;
                }
            })

            weekly_achievement_rate = (weekly_checked_todo_counts * (100 / weekly_todo_counts));
            num_of_weekly_todo.innerText = `${weekly_checked_todo_counts} / ${weekly_todo_counts}`;
            my_weekly_chart.data.datasets[0].data = [weekly_achievement_rate, (100 - weekly_achievement_rate)];
            my_weekly_chart.update();
        }
    });

    // 날짜 선택 버튼에 표시되는 날짜 바꾸기
    for (let i = 0; i <= 11; i++) {
        let month = document.querySelector(`#month-${i}`);
        if(month_of_today - i <= 0) {
            (month_of_today - i) + 12;
            month.innerText = `${year_of_today - 1}년 ${month_of_today - i + 12}월`;
            month.addEventListener('click', () => {
                marked_date_btn.innerText = `${year_of_today - 1}년 ${month_of_today - i + 12}월`;
                marked_date_btn.value = `${year_of_today - 1}-${refined_month(month_of_today - i + 12)}`;
                monthly_achievement_rate_title.innerText = `${year_of_today - 1}년 ${month_of_today - i + 12}월 달성률`;
                weekly_achievement_rate_title.innerText = `${year_of_today - 1}년 ${month_of_today - i + 12}월 1주차 달성률`;
            });
        } else {
            month.innerText = `${year_of_today}년 ${month_of_today - i}월`;
            month.addEventListener('click', () => {
                marked_date_btn.innerText = `${year_of_today}년 ${month_of_today - i}월`;
                marked_date_btn.value = `${year_of_today}-${refined_month(month_of_today - i)}`;
                monthly_achievement_rate_title.innerText = `${year_of_today}년 ${month_of_today - i}월 달성률`;
                if(i === 0) {
                    weekly_achievement_rate_title.innerText = `${year_of_today}년 ${month_of_today - i}월 ${week_of_todays_date}주차 달성률`;
                } else {
                    weekly_achievement_rate_title.innerText = `${year_of_today}년 ${month_of_today - i}월 1주차 달성률`;
                }
            });
        }

        month.addEventListener('click', () => {
            // 월별 달성률 바꾸기
            monthly_todo_counts = 0;
            raw_todo.find(mtc => {
                if(mtc.tdate.startsWith(marked_date_btn.value)) {
                    monthly_todo_counts++;
                }
            })
            monthly_checked_todo_counts = 0;
            raw_todo.find(mtct => {
                if(mtct.tdate.startsWith(marked_date_btn.value) && mtct.is_checked === 1) {
                monthly_checked_todo_counts++;
                }
            })
            monthly_achievement_rate = (monthly_checked_todo_counts * (100 / monthly_todo_counts));
            num_of_monthly_todo.innerText = `${monthly_checked_todo_counts} / ${monthly_todo_counts}`;
            my_monthly_chart.data.datasets[0].data = [monthly_achievement_rate, (100 - monthly_achievement_rate)];
            my_monthly_chart.update();

            // 주별 달성률 바꾸기
            if(month.id === 'month-0') {
                week_value_storage_input.value = week_of_todays_date;
            } else {
                week_value_storage_input.value = 1;
            }

            weekly_todo_counts = 0;
            raw_todo.find(wtc => {
                let converted_date = new Date(wtc.tdate);
                if(wtc.tdate.startsWith(marked_date_btn.value) && getWeek(converted_date) == week_value_storage_input.value) {
                    weekly_todo_counts++;
                }
            })

            weekly_checked_todo_counts = 0;
            raw_todo.find(wctc => {
                let converted_date = new Date(wctc.tdate);
                if(wctc.tdate.startsWith(marked_date_btn.value) && getWeek(converted_date) == week_value_storage_input.value && wctc.is_checked === 1) {
                    weekly_checked_todo_counts++;
                }
            })
            
            weekly_achievement_rate = (weekly_checked_todo_counts * (100 / weekly_todo_counts));
            num_of_weekly_todo.innerText = `${weekly_checked_todo_counts} / ${weekly_todo_counts}`;
            my_weekly_chart.data.datasets[0].data = [weekly_achievement_rate, (100 - weekly_achievement_rate)];
            my_weekly_chart.update();
        });
    };

    // 소셜 로그인 회원 정보
    let user_info = document.querySelector('#user_info');
    let auth_userid = `{{ Auth::user() -> userid }}`;
    let auth_email = `{{ Auth::user() -> email }}`;
    let acct_del_btn = document.querySelector('#acct_del_btn');

    // 구글
    if(auth_userid == '' && auth_email) {
        user_info.innerHTML = `
            <div>이름 : {{ Auth::user() -> name }}</div>
            <div>이메일 : ${auth_email}</div>
            <h5 class="mt-1">
                <span class="badge text-bg-primary ">구글 계정</span>
            </h5>
        `;
    }

    // 네이버
    if(auth_userid == '' && auth_email == '') {
        user_info.innerHTML = `
            <div>이름 : {{ Auth::user()->name }}</div>
            <h5 class="mt-1">
                <span class="badge text-bg-success ">네이버 계정</span>
            </h5>
        `;
    }

    // 소셜 계정에는 비밀번호 수정 부분 안 보이기
    let pswd_update_card = document.querySelector('#pswd_update_card');
    if(auth_userid == '' || auth_email == '') {
        pswd_update_card.style.display = 'none';
    }

    // 회원 탈퇴
    let unable_to_recover_ID = document.querySelector('#unable_to_recover_ID');
    let disappear_user_info = document.querySelector('#disappear_user_info');
    let del_acct_btn = document.querySelector('#del_acct_btn');

    unable_to_recover_ID.addEventListener('change', () => {
        if (unable_to_recover_ID.checked && disappear_user_info.checked) {
            del_acct_btn.disabled = false;
        } else {
            del_acct_btn.disabled = true;
        }
    });

    disappear_user_info.addEventListener('change', () => {
        if (disappear_user_info.checked && unable_to_recover_ID.checked) {
            del_acct_btn.disabled = false;
        } else {
            del_acct_btn.disabled = true;
        }
    });
</script>

<style>
    .custom-modal-width {
        width: 40%;
        max-width: none;
        margin: auto;
    }

    .card-header {
        background-color: palegoldenrod;
        font-weight: bold;
    }

    .form-check-input {
        width: 1.5em;
        height: 1.5em;
    }

    .form-check-input:checked {
        background-color: salmon;
        border-color: salmon;
    }

    .form-check-input:focus {
        border-color: salmon;
        box-shadow: 0 0 0 0.2rem rgba(250, 128, 114, 0.3);
    }
</style>
@endsection