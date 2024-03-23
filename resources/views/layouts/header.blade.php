@if (auth()->guard('admin')->user())
    @include('layouts.admin.header')
@else
    @include('layouts.user.header')
@endif