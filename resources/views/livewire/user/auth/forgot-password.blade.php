<div class="s3-container">
    <div class="s3-page">
        <div>
            <h2>Welcome to {{ config('app.name') }}</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis arcu ut dolor placerat tincidunt ut nec
                odio.</p>
        </div>
    </div>
    {{-- /.s3-page --}}

    <div class="s3-authbox">
        <div class="container">
            <div class="row m-2">
                <div class="col-12 text-center">
                    <h2>Reset your password</h2>
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}

            @if (session('success'))
                <div class="row mx-5">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="row mx-5">
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif

            <form wire:submit="forgotPassword">

                <div class="row mx-5">
                    <div class="col-12 mb-2">
                        <input type="email" wire:model.live.debounce.150ms="email" class="form-control" placeholder="Email">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mb-2">
                        <button type="submit" class="btn btn-primary">
                            Reset Password
                        </button>
                        <span wire:loading><i class="fas fa-spinner fa-spin"></i></span>
                    </div>

                    <div class="col-12 mb-">
                        <a wire:navigate href="{{ route('login') }}">Login</a>
                    </div>

                </div>

            </form>
        </div>
        {{-- /.container --}}
    </div>
    {{-- /.s3-authbox --}}
</div>
{{-- /.s3-container --}}


@push('styles')
@endpush


@push('scripts')
@endpush