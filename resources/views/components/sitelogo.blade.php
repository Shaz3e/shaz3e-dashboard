@props(['route' => ''])

@php
    $url = $route ? route($route) : '#';
@endphp

<div class="navbar-brand-box">
    <a href="{{ $url }}" class="logo logo-dark">
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo-sm" height="22">
        </span>
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo-dark" height="20">
        </span>
    </a>

    <a href="{{ $url }}" class="logo logo-light">
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo-sm-light" height="22">
        </span>
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo-light.png') }}" alt="logo-light" height="20">
        </span>
    </a>
</div>
