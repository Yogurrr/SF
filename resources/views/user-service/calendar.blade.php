@extends('layouts.app-layouts')
@section('content')
<main>
    <div class="row">
        <!-- 왼쪽 -->
        <div class="col-7">
            <!-- 달력 맨 윗줄 -->
            <div class="row pt-2 pb-2" style="background-color: palegoldenrod;">
                <div class="col-8">
                    <a class="text-start fw-bold fs-5" id="selectDate" style="text-decoration: none; color: black;"
                        href="javascript:void(0);" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="bottom"></a>
                </div>
                <div class="col-2">
                    <a class="text-end fw-bold fs-5" id="selectToday" style="text-decoration: none; color: black;"
                        href="javascript:void(0);">Today</a>
                </div>
                <div class="col-1">
                    <a class="text-end fw-bold fs-5" id="selectPrevMonth"
                        style="text-decoration: none; color: black;" href="javascript:void(0);"><</a>
                </div>
                <div class="col-1">
                    <a class="text-start fw-bold fs-5" id="selectNextMonth"
                        style="text-decoration: none; color: black;" href="javascript:void(0);">></a>
                </div>
            </div>
            <!-- 요일 -->
            <div class="row mt-2 mb-2">
                <div class="col text-center fs-5">월</div>
                <div class="col text-center fs-5">화</div>
                <div class="col text-center fs-5">수</div>
                <div class="col text-center fs-5">목</div>
                <div class="col text-center fs-5">금</div>
                <div class="col text-center fs-5">토</div>
                <div class="col text-center fs-5">일</div>
            </div>
            <div id="dates" class="row"></div>
        </div>
        <!-- 오른쪽 -->
        <div class="col-5 ps-1">
            <div class="row">
                <div class="col-3 fs-5 fw-bold ms-3 pt-2 pb-2 d-flex justify-content-center align-items-center"
                    style="background-color: darkgoldenrod">일정</div>
                <div class="col-auto p-0">
                    <button type="button" class="p-0" style="border: none; background-color: white; display: none;" 
                        data-bs-toggle="modal" data-bs-target="#add_and_mod_modal" id="schAddBtn">
                        <img src="/image/add.png" class="p-0" alt="" style="width: 70%;">
                    </button>
                </div>
            </div>
            <div class="ms-3 mt-2" id="scheduleList"></div>

            <div class="row mt-5">
                <div class="col-3 fs-5 fw-bold ms-3 pt-2 pb-2 d-flex justify-content-center align-items-center"
                    style="background-color: goldenrod">TO-DO</div>
                <div class="col-auto p-0">
                    <button type="button" class="p-0" style="border: none; background-color: white; display: none;"
                        data-bs-toggle="modal" data-bs-target="#add_and_mod_modal" id="todoAddBtn">
                        <img src="/image/add.png" class="p-0" alt="" style="width: 70%;">
                    </button>
                </div>
            </div>
            <div class="ms-3 mt-2" id="todoList"></div>
            <input type="hidden" id="storedDate"/>

            <!-- test -->
            

        </div>
    </div>
</main>



<!-- 일정 & 투두 등록 및 수정 모달 -->
<div class="modal fade" id="add_and_mod_modal" tabindex="-1" aria-labelledby="add_and_mod_modal_label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn-close border fs-4" style="width: 7%; background-color: palegoldenrod;"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('update-schedule') }}" method="POST" id="add_and_mod_form">
                @csrf
                <input type="hidden" id="date_or_num" name="date_or_num">
                <div class="row">
                    <input type="text" placeholder="일정 이름" class="offset-1 col-9 fs-4" id="add_and_mod_input" name="add_and_mod_input"
                        style="border-top: none; border-left: none; border-right: none; border-color: palegoldenrod;"
                        maxlength="50">
                </div>
                <div class="row mt-4">
                    <div class="offset-1 col-9">
                        <div class="row">
                            <button type="submit" class="btn col-6 fw-bold" style="background-color: palegoldenrod;">확인</button>
                            <button type="button" class="btn col-6 fw-bold border border-2" data-bs-dismiss="modal">취소</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 일정 & 투두 삭제 재확인 모달 -->
<div class="modal fade" id="deletion_reconfirmation_modal" tabindex="-1" aria-labelledby="deletion_reconfirmation_modal_label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn-close border fs-4" data-bs-dismiss="modal" aria-label="Close"
                    style="width: 7%; background-color: palegoldenrod;"></button>
            </div>
            <form action="{{ route('delete-schedule') }}" method="POST" id="deletion_reconfirmation_form">
                @csrf
                <input type="hidden" id="num_to_delete" name="num_to_delete">
                <div class="row text-center mt-2 fs-5">
                    <p>정말로 <span style="color: orangered;">삭제</span>하시겠습니까?</p>
                </div>
                <div class="row mt-4">
                    <div class="offset-1 col-9">
                        <div class="row">
                            <button type="submit" class="btn col-6 fw-bold" style="background-color: palegoldenrod;">확인</button>
                            <button type="button" class="btn col-6 fw-bold border border-2" data-bs-dismiss="modal">취소</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 이동 모달 -->
<div class="modal fade" id="shift_modal" tabindex="-1" aria-labelledby="shift_modal_label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal-width">
        <div class="modal-content p-4">
            <div class="row">
                <div class="col-10 fw-bold d-flex align-items-center justify-content-center">
                    <div class="ps-5" style="font-size: 18px;">날짜 이동</div>
                </div>
                <div class="col-2 d-flex justify-content-end">
                    <button type="button" class="btn-close border fs-4" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: palegoldenrod;"></button>
                </div>
            </div>
            
            <form action="{{ route('move-todo') }}" method="POST" id="shift_form">
                @csrf
                <input type="hidden" id="shift_value" name="shift_value">
                <input type="hidden" id="shift_date" name="shift_date">
                <!-- 모달 내용 -->
                <div class="row">
                    <div class="offset-1 col-10">
                        <div class="row text-center mt-4">
                            <div class="col-8 text-start">
                                <a class="text-start fw-bold" id="modal_year" style="text-decoration: none; color: black; font-size: 18px;"
                                    href="javascript:void(0);"></a>
                            </div>
                            <div class="col-2">
                                <a class="text-end fw-bold" id="modal_today" style="text-decoration: none; color: black; font-size: 18px;"
                                    href="javascript:void(0);">Today</a>
                            </div>
                            <div class="col-1">
                                <a class="text-end fw-bold fs-5" id="modal_prev"
                                    style="text-decoration: none; color: black;" href="javascript:void(0);"><</a>
                            </div>
                            <div class="col-1">
                                <a class="text-start fw-bold fs-5" id="modal_next"
                                    style="text-decoration: none; color: black;" href="javascript:void(0);">></a>
                            </div>
                        </div>
                        <!-- 요일 -->
                        <div class="row mt-3 mb-2">
                            <div class="col text-center" style="font-size: 17px;">월</div>
                            <div class="col text-center" style="font-size: 17px;">화</div>
                            <div class="col text-center" style="font-size: 17px;">수</div>
                            <div class="col text-center" style="font-size: 17px;">목</div>
                            <div class="col text-center" style="font-size: 17px;">금</div>
                            <div class="col text-center" style="font-size: 17px;">토</div>
                            <div class="col text-center text-danger" style="font-size: 17px;">일</div>
                        </div>
                        <div id="modal_dates" class="row"></div>
                        <div class="row mt-4">
                            <button type="submit" class="btn offset-1 col-10 fw-bold" style="background-color: palegoldenrod;">확인</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    <?php 
        echo "let scounts = " . json_encode($scounts) . ";";
        echo "let tcounts = " . json_encode($tcounts) . ";";
    ?>

    let date = new Date();

    let renderCalendar = () => {
        let viewYear = date.getFullYear();
        let viewMonth = date.getMonth();

        // 현재 연도와 월 표시
        document.getElementById("selectDate").textContent = `${viewYear}년 ${viewMonth + 1}월`;

        // 이전 달 마지막 날과 이번 달 마지막 날
        let prevLast = new Date(viewYear, viewMonth, 0);
        let thisLast = new Date(viewYear, viewMonth + 1, 0);

        let PLDate = prevLast.getDate();
        let PLDay = prevLast.getDay();

        let TLDate = thisLast.getDate();
        let TLDay = thisLast.getDay();

        let prevDates = [];
        let thisDates = [...Array(TLDate + 1).keys()].slice(1);
        let nextDates = [];

        if (PLDay !== 0) {
            for (let i = 0; i < PLDay; i++) {
                prevDates.unshift(PLDate - i);
            }
        }
        if (TLDay !== 0) {
            for (let i = 1; i <= 7 - TLDay; i++) {
                nextDates.push(i);
            }
        }
        let dates = prevDates.concat(thisDates, nextDates);

        let firstDateIndex = dates.indexOf(1);   // 이번 달 1일의 인덱스 찾기
        let lastDateIndex = dates.lastIndexOf(TLDate);   // 이번 달 마지막 날의 인덱스 찾기

        dates.forEach((date, i) => {
            let condition = (i >= firstDateIndex && i < lastDateIndex + 1) ? "this"
                : (i < firstDateIndex && i < lastDateIndex + 1) ? "prev" : "next";

            // 월 앞에 0 붙이기
            let exactMonth = (i, firstDateIndex, lastDateIndex, viewMonth) => {
                if (viewMonth + 1 < 10) {
                    if (i >= firstDateIndex && i < lastDateIndex + 1) {
                        return '0' + (viewMonth + 1);
                    } else if (i < firstDateIndex && i < lastDateIndex + 1) {
                        return '0' + viewMonth;
                    } else {
                        return '0' + (viewMonth + 2);
                    }
                } else {
                    if (i >= firstDateIndex && i < lastDateIndex + 1) {
                        return viewMonth + 1;
                    } else if (i < firstDateIndex && i < lastDateIndex + 1) {
                        return viewMonth;
                    } else {
                        return viewMonth + 2;
                    }
                }
            }

            // 일 앞에 0 붙이기
            let exactDate = (date) => {
                if (date < 10) {
                    return '0' + date;
                } else {
                    return date;
                }
            }

            dates[i] = `
                    <div class="date text-center col-2 border-top pt-1 btn" style="width: 14.28%; height: 110px;">
                        <div class="mb-1 dateDiv">
                            <span class="${condition}">${date}</span>
                        </div>
                        <input type=hidden class="dateInput" value="${viewYear}-${exactMonth(i, firstDateIndex, lastDateIndex, viewMonth)}-${exactDate(date)}">
                    </div>
                `;
        })
        document.getElementById("dates").innerHTML = dates.join("");

        // 달력에 일정 및 투두 갯수 띄우기
        let diElements = document.querySelectorAll(".dateInput");

        let tcntItem = tcounts.find(tcntItem => {
            diElements.forEach(di => {
                if (tcntItem.tdate === di.value) {
                    let tdCntDiv = document.createElement("div");

                    tdCntDiv.classList.add("tcd");
                    tdCntDiv.innerHTML = "to-do " + tcntItem.count + "개";
                    tdCntDiv.style.backgroundColor = "goldenrod";
                    tdCntDiv.classList.add("fw-bold");
                    tdCntDiv.classList.add("rounded");

                    di.after(tdCntDiv);
                }
            })
        })
        let scntItem = scounts.find(scntItem => {
            diElements.forEach(di => {
                if (scntItem.sdate === di.value) {
                    let schCntDiv = document.createElement("div");
                    schCntDiv.classList.add("scd");
                    schCntDiv.innerHTML = "일정 " + scntItem.count + "개";
                    schCntDiv.style.backgroundColor = "darkgoldenrod";
                    schCntDiv.classList.add("fw-bold");
                    schCntDiv.classList.add("rounded");
                    di.after(schCntDiv);
                }
            })
        });

        // 오늘 날짜 표시
        let today = new Date();

        if (viewMonth === today.getMonth() && viewYear === today.getFullYear()) {
            for (let date of document.querySelectorAll(".this")) {
                if (+date.innerText === today.getDate()) {
                    date.classList.add("today", "fw-bold", "rounded", "ps-1", "pe-1", "pb-1");
                    break;
                }
            }
        }

        // 일정 띄우기
        let dateAll = document.querySelectorAll(".date")
        dateAll.forEach(function (clickedDate) {
            clickedDate.addEventListener("click", function () {

                // 일정 & 투두 추가 버튼 보이기
                let schAddBtn = document.querySelector("#schAddBtn");
                schAddBtn.style.display = "block";
                let todoAddBtn = document.querySelector("#todoAddBtn");
                todoAddBtn.style.display = "block";

                // 보낼 value 가져오기
                let dateValue = clickedDate.querySelector('input').value;
                let dateCondition = clickedDate.querySelector('span').innerText;
                storedDate.value = dateValue;

                // 등록 및 수정 모달 date value
                let date_or_num = document.querySelector('#date_or_num');
                date_or_num.value = dateValue;

                // 등록 모달 내용 바꾸기
                let add_and_mod_form = document.querySelector('#add_and_mod_form');
                let add_and_mod_input = document.querySelector('#add_and_mod_input');
                schAddBtn.addEventListener('click', () => {
                    add_and_mod_form.action = "{{ route('add-schedule') }}";
                    add_and_mod_input.placeholder = '일정 이름';
                });
                todoAddBtn.addEventListener('click', () => {
                    add_and_mod_form.action = "{{ route('add-todo') }}";
                    add_and_mod_input.placeholder = 'to-do';
                });

                // 이동 모달에 달력 띄우기
                let date_in_modal = new Date(dateValue);
                let show_modal_calendar = () => {
                    let modal_view_year = new Date(date_in_modal).getFullYear();
                    let modal_view_month = new Date(date_in_modal).getMonth();
                    
                    let modal_year = document.querySelector('#modal_year');
                    modal_year.innerText = `${modal_view_year}년 ${modal_view_month + 1}월`;

                    // 이전 달 마지막 날과 이번 달 마지막 날
                    let last_prev_month = new Date(modal_view_year, modal_view_month, 0);
                    let last_this_month = new Date(modal_view_year, modal_view_month + 1, 0);

                    let lpm_date = last_prev_month.getDate();
                    let lpm_day = last_prev_month.getDay();

                    let ltm_date = last_this_month.getDate();
                    let ltm_day = last_this_month.getDay();

                    let prev_month_dates = [];
                    let this_month_dates = [...Array(ltm_date + 1).keys()].slice(1);
                    let next_month_dates = [];

                    if (lpm_day !== 0) {
                        for (let i = 0; i < lpm_day; i++) {
                            prev_month_dates.unshift(lpm_date - i);
                        }
                    }
                    if (ltm_day !== 0) {
                        for (let i = 1; i <= 7 - ltm_day; i++) {
                            next_month_dates.push(i);
                        }
                    }
                    let modal_dates = prev_month_dates.concat(this_month_dates, next_month_dates);
                
                    let index_for_1st = modal_dates.indexOf(1);
                    let index_for_last = modal_dates.lastIndexOf(ltm_date);
                
                    modal_dates.forEach((date, i) => {
                        let condition = (i >= index_for_1st && i < index_for_last + 1) ? "this"
                            : (i < index_for_1st && i < index_for_last + 1) ? "prev" : "next";
                    
                        // 월 앞에 0 붙이기
                        let month_with_zero = (i, index_for_1st, index_for_last, modal_view_month) => {
                            if (modal_view_month + 1 < 10) {
                                if (i >= index_for_1st && i < index_for_last + 1) {
                                    return '0' + (modal_view_month + 1);
                                } else if (i < index_for_1st && i < index_for_last + 1) {
                                    return '0' + modal_view_month;
                                } else {
                                    return '0' + (modal_view_month + 2);
                                }
                            } else {
                                if (i >= index_for_1st && i < index_for_last + 1) {
                                    return modal_view_month + 1;
                                } else if (i < index_for_1st && i < index_for_last + 1) {
                                    return modal_view_month;
                                } else {
                                    return modal_view_month + 2;
                                }
                            }
                        }
                    
                        // 일 앞에 0 붙이기
                        let date_with_zero = (date) => {
                            if (date < 10) {
                                return '0' + date;
                            } else {
                                return date;
                            }
                        }
                    
                        modal_dates[i] = `
                                <div class="mdate text-center col-2 pt-1 btn d-flex align-items-center justify-content-center" style="width: 14.28%; height: 50px;">
                                    <div class="mb-1 mdate_child">
                                        <span class="${condition} mdate_span">${date}</span>
                                    </div>
                                    <input type=hidden class="modal_date_input" value="${modal_view_year}-${month_with_zero(i, index_for_1st, index_for_last, modal_view_month)}-${date_with_zero(date)}">
                                </div>
                            `;
                    })
                    document.getElementById("modal_dates").innerHTML = modal_dates.join("");

                    // 일요일 색깔 바꾸기
                    let modal_date_input_all = document.querySelectorAll('.modal_date_input');
                    modal_date_input_all.forEach(mdi => {
                        if(new Date(mdi.value).getDay() === 0) {
                            mdi.previousElementSibling.classList.add("text-danger");
                        }
                    })

                    // 클릭하면 색깔 바꾸기
                    let mdate_all = document.querySelectorAll('.mdate');
                    let mdate_child_all = document.querySelectorAll('.mdate_child');
                    mdate_all.forEach(ma => {
                        ma.addEventListener('click', () => {
                            mdate_all.forEach(ma2 => {
                                ma2.classList.remove("selected_modal_date");
                                ma2.style.backgroundColor = "";
                            })
                            ma.classList.add("selected_modal_date");
                            let selected_modal_date = document.querySelector('.selected_modal_date');
                            selected_modal_date.style.backgroundColor = "cornflowerblue";

                            // 모달창에 날짜 보내기
                            let shift_date = document.querySelector('#shift_date');
                            shift_date.value = ma.children[1].value;
                        });
                    })

                    mdate_child_all.forEach(mc => {
                        mc.addEventListener('click', () => {
                            mdate_all.forEach(ma => {
                                ma.classList.remove("selected_modal_date");
                                ma.style.backgroundColor = "";
                            })
                            mc.parentElement.classList.add("selected_modal_date");
                            let selected_modal_date = document.querySelector('.selected_modal_date');
                            selected_modal_date.style.backgroundColor = "cornflowerblue";
                        });
                    })
                }
                show_modal_calendar();

                let modal_prev = document.querySelector('#modal_prev');
                modal_prev.addEventListener('click', () => {
                    date_in_modal.setMonth(date_in_modal.getMonth() - 1);
                    show_modal_calendar();
                });
                let modal_next = document.querySelector('#modal_next');
                modal_next.addEventListener('click', () => {
                    date_in_modal.setMonth(date_in_modal.getMonth() + 1);
                    show_modal_calendar();
                });

                // AJAX
                var httpRequest;
                let dateVariable = storedDate.value;
                httpRequest = new XMLHttpRequest();
                httpRequest.onreadystatechange = () => {
                    if (httpRequest.readyState === XMLHttpRequest.DONE) {
                        if (httpRequest.status === 200) {
                            let result = httpRequest.response;
                            const events = result.schedules;
                            const todos = result.todos;
                            const scheduleList = document.getElementById("scheduleList");
                            const todoList = document.getElementById("todoList");

                            scheduleList.innerText = '';
                            todoList.innerText = '';

                            let num_to_delete = document.querySelector('#num_to_delete');
                            let deletion_reconfirmation_form = document.querySelector('#deletion_reconfirmation_form');
                            let num_to_modify = document.querySelector('#num_to_modify');
                            let modify_input = document.querySelector('#modify_input');
                            let modify_form = document.querySelector('#modify_form');

                            // 이동 관련 변수
                            let shift_form = document.querySelector('#shift_form');
                            let shift_value = document.querySelector('#shift_value');
                            let mdate_all = document.querySelectorAll('.mdate');
                            let mdate_span_all = document.querySelectorAll('.mdate_span');

                            // 이동 관련 함수
                            let find_date = () => {
                                if(dateValue.substr(-2, 2).startsWith(0)) {
                                    return dateValue.substr(-1);
                                } else {
                                    return dateValue.substr(-2, 2);
                                }
                            }

                            // 일정 부분
                            events.forEach(ev => {
                                scheduleList.innerHTML += `
                                    <div class="row border rounded mb-2">
                                        <div class="col-10 d-flex align-items-center" style="font-size: 17px;">${ev.schedule}</div>
                                        <button type="button" class="btn col-2 p-0 fw-bold fs-4" data-bs-toggle="collapse" 
                                            data-bs-target="#moreCollapse${ev.sno}" aria-expanded="false" aria-controls="moreCollapse${ev.sno}">···</button>
                                    </div>
                                    <div class="collapse row mb-2" id="moreCollapse${ev.sno}">
                                        <button class="btn col-2 border offset-6 move_sch_btn" data-bs-toggle="modal" 
                                            data-bs-target="#shift_modal" value="${ev.sno}">이동</button>
                                        <button class="btn col-2 border modSchBtn" data-bs-toggle="modal" data-bs-target="#add_and_mod_modal"
                                            style="color: royalblue" value="${ev.schedule}" name="${ev.sno}">수정</button>
                                        <button class="btn col-2 border delSchBtn" data-bs-toggle="modal" data-bs-target="#deletion_reconfirmation_modal" 
                                            style="color: orangered;" value="${ev.sno}">삭제</button>
                                    </div>
                                `;

                                // 등록 및 수정 모달창에 sno & 기존 일정 내용 보내기
                                let modSchBtnAll = document.querySelectorAll(".modSchBtn");
                                modSchBtnAll.forEach(msb => {
                                    msb.addEventListener('click', () => {
                                        date_or_num.value = msb.name;
                                        add_and_mod_input.value = msb.value;
                                        add_and_mod_input.placeholder = '일정 이름';
                                        add_and_mod_form.action = "{{ route('update-schedule') }}";
                                    })
                                })

                                // 일정 삭제 재확인 모달창에 sno value 보내기
                                let delSchBtnAll = document.querySelectorAll(".delSchBtn");
                                delSchBtnAll.forEach(dsb => {
                                    dsb.addEventListener('click', () => {
                                        num_to_delete.value = dsb.value;
                                        deletion_reconfirmation_form.action = "{{ route('delete-schedule') }}";
                                    });
                                })

                                // 일정 날짜 이동
                                let move_sch_btn_all = document.querySelectorAll('.move_sch_btn');
                                move_sch_btn_all.forEach(msb => {
                                    msb.addEventListener('click', () => {
                                        // 이동 버튼 클릭 시 배경 초기화
                                        mdate_all.forEach(ma => {
                                            ma.classList.remove("selected_modal_date");
                                            ma.style.backgroundColor = "";
                                        })
                                        // 기본 달력에서 선택한 날짜 모달 달력에 초기 표시
                                        mdate_span_all.forEach(ms => {
                                            if(ms.innerText === find_date() && selectDate.innerText === modal_year.innerText && ms.classList.contains('this')) {
                                                ms.parentElement.parentElement.classList.add("selected_modal_date");
                                                let selected_modal_date = document.querySelector('.selected_modal_date');
                                                selected_modal_date.style.backgroundColor = "cornflowerblue";
                                            }
                                        })
                                        // 모달에 sno 보내기
                                        shift_value.value = msb.value;

                                        // route 바꾸기
                                        shift_form.action = "{{ route('move-schedule') }}";
                                    });
                                })
                            })

                            // 투두 부분
                            todos.forEach(td => {
                                todoList.innerHTML += `
                                    <div class="row border rounded mb-2">
                                        <div class="form-check col-10 d-flex align-items-center ps-0 m-0" style="font-size: 17px;">
                                            <input class="form-check-input ms-2 mt-0" type="checkbox" value="${td.tno}" id="todoCheck" ${td.is_checked == 1 ? ' checked' : ''}>
                                            <label class="form-check-label ps-2" for="todoCheck">${td.to_do}</label>
                                        </div>
                                        <button type="button" class="btn col-2 p-0 fw-bold fs-4" data-bs-toggle="collapse" data-bs-target="#todoMoreCollapse${td.tno}" 
                                            aria-expanded="false" aria-controls="todoMoreCollapse${td.tno}">···</button>
                                    </div>
                                    <div class="collapse row mb-2" id="todoMoreCollapse${td.tno}">
                                        <button class="btn col-2 border offset-6 move_todo_btn" data-bs-toggle="modal" 
                                            data-bs-target="#shift_modal" value="${td.tno}">이동</button>
                                        <button class="btn col-2 border modTodoBtn" data-bs-toggle="modal" data-bs-target="#add_and_mod_modal"
                                            style="color: royalblue" value="${td.to_do}" name="${td.tno}">수정</button>
                                        <button class="btn col-2 border delTodoBtn" data-bs-toggle="modal" data-bs-target="#deletion_reconfirmation_modal" 
                                            style="color: orangered;" value="${td.tno}">삭제</button>
                                    </div>
                                `;

                                // 등록 및 수정 모달창에 tno & 기존 일정 내용 보내기
                                let modTodoBtnAll = document.querySelectorAll(".modTodoBtn");
                                modTodoBtnAll.forEach(mtb => {
                                    mtb.addEventListener('click', () => {
                                        date_or_num.value = mtb.name;
                                        add_and_mod_input.value = mtb.value;
                                        add_and_mod_input.placeholder = 'to-do';
                                        add_and_mod_form.action = "{{ route('update-todo') }}";
                                    });
                                })

                                // 투두 삭제 재확인 모달창에 tno value 보내기
                                let delTodoBtnAll = document.querySelectorAll(".delTodoBtn");
                                delTodoBtnAll.forEach(dtb => {
                                    dtb.addEventListener('click', () => {
                                        num_to_delete.value = dtb.value;
                                        deletion_reconfirmation_form.action = "{{ route('delete-todo') }}";
                                    });
                                })

                                // 체크박스 체크 여부 저장
                                let todoCheckAll = document.querySelectorAll(".form-check-input");
                                todoCheckAll.forEach(tc => {
                                    tc.addEventListener('change', () => {
                                        let isChecked = tc.checked ? 1 : 0;
                                        let tnoValue = tc.value;

                                        fetch('/save-checkbox-status', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                            },
                                            body: JSON.stringify({ checked: isChecked, tnoValue: tnoValue })
                                        })
                                        .then(response => response.json())
                                        .catch(error => console.error('Error:', error));
                                    })
                                })

                                // 투두 날짜 이동
                                let move_todo_btn_all = document.querySelectorAll('.move_todo_btn');
                                move_todo_btn_all.forEach(mtb => {
                                    mtb.addEventListener('click', () => {
                                        // 이동 버튼 클릭 시 배경 초기화
                                        mdate_all.forEach(ma => {
                                            ma.classList.remove("selected_modal_date");
                                            ma.style.backgroundColor = "";
                                        })
                                        // 기본 달력에서 선택한 날짜 모달 달력에 초기 표시
                                        mdate_span_all.forEach(ms => {
                                            if(ms.innerText === find_date() && selectDate.innerText === modal_year.innerText && ms.classList.contains('this')) {
                                                ms.parentElement.parentElement.classList.add("selected_modal_date");
                                                let selected_modal_date = document.querySelector('.selected_modal_date');
                                                selected_modal_date.style.backgroundColor = "cornflowerblue";
                                            }
                                        })
                                        // 모달에 tno 보내기
                                        shift_value.value = mtb.value;

                                        // route 바꾸기
                                        shift_form.action = "{{ route('move-todo') }}";
                                    });
                                })
                            })
                        } else {
                            alert('Request Error!');
                        }
                    }
                };
                httpRequest.open('GET', '/getScheduleByDate?dateVariable=' + dateVariable);
                httpRequest.responseType = "json";
                httpRequest.send();

                // 클릭하면 배경색 바꾸기
                let tcd = document.querySelector(".tcd");
                let scd = document.querySelector(".scd");
                if(event.target.classList.contains("date")) {
                    document.querySelectorAll(".date").forEach(day => {
                        day.classList.remove("selected-date");
                        day.style.backgroundColor = "";
                    });
                    event.target.classList.add("selected-date");

                    let selectedDate = document.querySelector('.selected-date');
                    selectedDate.style.backgroundColor = "rgba(238 , 232 , 170, 0.7)";
                } else if (event.target.classList.contains("tcd") || event.target.classList.contains("scd") || event.target.classList.contains("dateDiv")) {
                    document.querySelectorAll(".date").forEach(day => {
                        day.classList.remove("selected-date");
                        day.style.backgroundColor = "";
                    });
                    let parentDiv = event.target.parentElement;
                    parentDiv.classList.add("selected-date");

                    let selectedDate = document.querySelector('.selected-date');
                    selectedDate.style.backgroundColor = "rgba(238 , 232 , 170, 0.7)";
                } else if (event.target.classList.contains("prev") || event.target.classList.contains("this") || event.target.classList.contains("next")) {
                    document.querySelectorAll(".date").forEach(day => {
                        day.classList.remove("selected-date");
                        day.style.backgroundColor = "";
                    });
                    let parentDiv = event.target.parentElement;
                    let grandParentDiv = parentDiv.parentElement;
                    grandParentDiv.classList.add("selected-date");

                    let selectedDate = document.querySelector('.selected-date');
                    selectedDate.style.backgroundColor = "rgba(238 , 232 , 170, 0.7)";
                }
            });
        });
    }
    renderCalendar();

    document.getElementById("selectPrevMonth").addEventListener("click", function () {
        date.setMonth(date.getMonth() - 1);
        renderCalendar();
        scheduleList.innerText = '';
        todoList.innerText = '';
    });

    document.getElementById("selectNextMonth").addEventListener("click", function () {
        date.setMonth(date.getMonth() + 1);
        renderCalendar();
        scheduleList.innerText = '';
        todoList.innerText = '';
    });

    document.getElementById("selectToday").addEventListener("click", function () {
        date = new Date();
        renderCalendar();
        scheduleList.innerText = '';
        todoList.innerText = '';
    });

    // Enable popovers
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

    let popover = new bootstrap.Popover(document.getElementById('selectDate'), {
        container: 'body',
        html: true,
        customClass: 'custom-popover',
        content: function() {
            return `
                <div id="popover_content"></div>
            `;
        }
    });

    // popover 안의 html 작성
    document.addEventListener('shown.bs.popover', function(event) {
        let year_in_popover = date.getFullYear();

        let popoverBody = document.querySelector('.popover-body');
        if (popoverBody) {
            let popover_content = popoverBody.querySelector('#popover_content');
            popover_content.innerHTML = `
                <div class="row">
                    <div class="col-8">
                        <button type="button" class="btn fs-5 fw-bold" id="pop_year" value="one"></button>
                    </div>
                    <button type="button" class="btn col-2 fs-5" id="plus">▲</button>
                    <button type="button" class="btn col-2 fs-5" id="minus">▼</button>
                </div>
                <div id="test_content">
                    <div class="row">
                        <button type="button" class="btn col-3 pop_num">1</button>
                        <button type="button" class="btn col-3 pop_num">2</button>
                        <button type="button" class="btn col-3 pop_num">3</button>
                        <button type="button" class="btn col-3 pop_num">4</button>
                    </div>
                    <div class="row">
                        <button type="button" class="btn col-3 pop_num">5</button>
                        <button type="button" class="btn col-3 pop_num">6</button>
                        <button type="button" class="btn col-3 pop_num">7</button>
                        <button type="button" class="btn col-3 pop_num">8</button>
                    </div>
                    <div class="row">
                        <button type="button" class="btn col-3 pop_num">9</button>
                        <button type="button" class="btn col-3 pop_num">10</button>
                        <button type="button" class="btn col-3 pop_num">11</button>
                        <button type="button" class="btn col-3 pop_num">12</button>
                    </div>
                </div>
            `;
        }

        let today = new Date();
        let pop_year = document.querySelector('#pop_year');
        let plus = document.querySelector('#plus');
        let minus = document.querySelector('#minus');
        let pop_num_all = document.querySelectorAll('.pop_num');

        pop_year.innerText = today.getFullYear();
        pop_year.value = 'one';

        let start = Math.floor(+pop_year.innerText / 10) * 10;
        let end = start + 9;

        pop_num_all.forEach(num => {
            num.value = num.innerText;
            num.addEventListener('click', () => {
                if(pop_year.value === 'ten') {
                    pop_year.value = 'one';
                    pop_year.innerText = num.innerText;
                    pop_num_all.forEach(n => {
                        n.innerText = n.value;
                        n.style.display = 'block';
                    });
                } else if(pop_year.value === 'one') {
                    date = new Date(pop_year.innerText, num.innerText - 1, 1);
                    renderCalendar();
                    scheduleList.innerText = '';
                    todoList.innerText = '';
                }
            });
        })

        pop_year.addEventListener('click', () => {
            if(pop_year.value === 'one') {
                pop_year.value = 'ten';
                pop_year.innerText = `${start} - ${end}`;

                pop_num_all.forEach(num => {
                    if(+num.innerText < 11) {
                        num.innerText = +num.innerText + start - 1;
                    } else {
                        num.style.display = 'none';
                    }
                })
            }
        });

        plus.addEventListener('click', () => {
            if(pop_year.value === 'one') {
                pop_year.innerText = +pop_year.innerText + 1;
                start = Math.floor(+pop_year.innerText / 10) * 10;
                end = start + 9;
            } else if(pop_year.value === 'ten') {
                start += 10;
                end = start + 9;
                pop_year.innerText = `${start} - ${end}`;
                pop_num_all.forEach(num => {
                    num.innerText = +num.innerText + 10;
                })
            }
        });

        minus.addEventListener('click', () => {
            if(pop_year.value === 'one') {
                pop_year.innerText = +pop_year.innerText - 1;
                start = Math.floor(+pop_year.innerText / 10) * 10;
                end = start + 9;
            } else if(pop_year.value === 'ten') {
                start -= 10;
                end = start + 9;
                pop_year.innerText = `${start} - ${end}`;
                pop_num_all.forEach(num => {
                    num.innerText = +num.innerText - 10;
                })
            }
        });
    });
</script>

<style>
    .prev {
        color: grey;
    }

    .next {
        color: grey;
    }

    .today {
        background-color: palegoldenrod;
    }

    .form-check-input {
        width: 1.5em;
        height: 1.5em;
    }

    .form-check-input:checked {
        background-color: gold;
        border-color: gold;
    }

    .form-check-input:focus {
        border-color: gold;
        box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.3);
    }

    .hidden-backdrop {
        display: none;
    }

    .custom-popover {
        width: 600px;
    }

    .custom-modal-width {
        width: 38%;
        max-width: none;
        margin: auto;
    }
</style>
@endsection