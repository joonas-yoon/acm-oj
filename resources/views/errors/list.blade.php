@if (count($errors) > 0)
    <div class="ui warning message">
        <i class="close icon"></i>
        <div class="header">
            앗! 문제가 생겼습니다.
        </div>
        <ul class="ui list">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif