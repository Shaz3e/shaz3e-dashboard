@if (auth()->guard('admin')->user())
    @include('layouts.admin.sidebar')
@else
    @include('layouts.user.sidebar')
@endif