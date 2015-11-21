<!DOCTYPE html>
<html lang="ko">
<head>
    @include('includes.head', ['site_title' => 'Orion Online Judge'])
</head>
<body class="hello">

    @include('includes.navigator', ['isIndex' => true])

    <!-- Start Intro -->
    <div class="ui introhead" id="context">
        <div class="ui container">
            <div class="introduction">
                <h1 class="ui inverted header">
                    <img class="logo" src="/images/logo-index.png"/>
                    <div class="title">Orion Judge</div>
                </h1>

                <div class="ui hidden divider"></div>
                <p class="subtitle">
                    An algorithm refers to a number of steps required for solving a problem.<br/>
                    It makes you to become a better, smarter, productive being!<br/>
                    Proof it now!
                </p>

                <div class="ui hidden divider"></div>
                <a href="/problems" class="ui inverted download button">Explore</a>
                <a href="/auth/login" class="ui inverted basic button">Sign In</a>
            </div>
        </div>
    </div>
    <div class="ui stripe segment">
        <div class="ui four column center aligned divided relaxed stackable grid container">
            <div class="row">
                <div class="column">

                    <div class="ui card">
                        <div class="content"><h2>오늘의 사용자</h2></div>
                        <div class="image">
                            <img src="http://semantic-ui.cn/images/avatar/large/steve.jpg"/>
                        </div>
                        <div class="content"><i class="bar chart icon"></i> 179 Solved, 52.23% </div>
                        <div class="ui two bottom attached buttons">
                            <div class="ui button">Explore</div>
                            <div class="ui red button">Versus</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="ui blue segment">새로 추가된 문제</div>
                    <div class="ui stacked segments">
                        @foreach($addedProblems as $problem)
                        <div class="ui segment">
                            <a href="/problems/{{ $problem->id }}" style="color:#333;">{{ $problem->title }}</a>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="column">
                    <div class="ui blue segment">최근 번역된 문제</div>
                    <div class="ui segments">
                        <div class="ui segment">
                            <p>탑</p>
                        </div>
                        <div class="ui segment">
                            <p>나랏말싸미</p>
                        </div>
                        <div class="ui segment">
                            <p>마라토너</p>
                        </div>
                        <div class="ui segment">
                            <p>맛있는 거 먹고싶다</p>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="ui blue segment">번역을 기다리는 문제</div>
                    <div class="ui raised segments">
                        <div class="ui segment">
                            <p>Top</p>
                        </div>
                        <div class="ui segment">
                            <p>Sdjustment toad</p>
                        </div>
                        <div class="ui segment">
                            <p>Sleepy Part</p>
                        </div>
                        <div class="ui segment">
                            <p>Enchanted distance</p>
                        </div>
                        <div class="ui segment">
                            <p>Puncture</p>
                        </div>
                        <div class="ui segment">
                            <p>cough</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ui stripe alternative segment">
        <div class="ui four statistics">
            <div class="statistic">
                <div class="value">220</div>
                <div class="label">개의 문제</div>
            </div>
            <div class="statistic">
                <div class="text value">
                    139<br/>
                    <div class="ui star rating" data-rating="2"></div>
                </div>
                <div class="label">개의 평가</div>
            </div>
            <div class="statistic">
                <div class="value">332</div>
                <div class="label">번의 제출</div>
            </div>
            <div class="statistic">
                <div class="value"><i class="child icon"></i>42</div>
                <div class="label">명의 회원</div>
            </div>
        </div>
    </div>

    @include('includes.footer')

    <script>
        $('.ui.rating')
            .rating({
                initialRating: 2,
                maxRating: 5
            })
        ;
    </script>
</body>
</html>