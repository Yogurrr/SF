# 정리
### 컨트롤러에서 log 쓰기
```
\Log::info('이것은 정보 로그입니다.');
```

### 'Var' vs 'Let' vs 'Const'
+ Var 
    - 함수 외부에서는 전역 범위
    - 함수 내부에서는 함수 범위
    - 변수 재선언 가능

+ Let
    - 선언된 블록 내에서만 사용 가능
    - 업데이트 가능
    - 재선언 불가능

+ Const
    - 선언된 블록 내에서만 사용 가능
    - 업데이트 불가능
    - 재선언 불가능

### 부모 & 자식 & 형제 요소 찾기
+ 부모 요소 찾기
    + parentElement : 부모 요소를 리턴
+ 자식 요소 찾기
    + children : 자식 요소 목록을 'HTMLCollection' 형태로 리턴
    + children[i] : 자식 요소 중, i 번째 요소를 리턴
    + firstElementChildren : 자식 요소 중, 첫 번째 요소를 리턴
    + lastElementChildren : 자식 요소 중, 마지막 요소를 리턴
+ 형제 요소 찾기
    + previousElementSibling : 같은 레벨의 노드 중, 이전 요소를 리턴
    + nextElementSibling : 같은 레벨의 노드 중, 다음 요소를 리턴

### 문자열 자르기
+ str.substr(start, [length])
    + 길이 부분을 생략하면 시작 위치부터 문자열 끝까지 자름
    + 음수 사용 가능
+ str.substring(indexStart, [indexEnd])
    + 인자에 음수(-)를 대입하면 해당 값은 '0'으로 치환
    + 종료 위치에 음수(-) 또는 '0'인 경우 첫 번째 인수와 두 번째 인수가 뒤바뀜
+ str.slice(beginIndex, [endIndex])
    + 음수(-)를 자유롭게 사용할 수 있어서 뒤에서부터 문자열을 자를 때 유용하게 사용