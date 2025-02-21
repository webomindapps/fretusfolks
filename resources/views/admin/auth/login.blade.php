<x-guest-layout>
    <div class="row">
        <div class="col-lg-5 mx-auto my-5">
            <div class="col-lg-12 text-center">
                <img src="{{ asset('admin/images/logo.png') }}" class="img-fluid logo_img" width="50px" height="50px">
            </div>
            <div class="login-card bg-white shadow-sm">
                <form action="{{ route('admin.login') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">

                        <div class="col-lg-12">
                            <h3 class="text-center my-4">Sign in to continue</h3>
                            <div class="mb-3">
                                <select name="role" class="form-select" style="border-radius: 10px !important;" required>
                                    <option value="">Select User Type</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="group">

                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-check">
                                    <path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8" />
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                    <path d="m16 19 2 2 4-4" />
                                </svg>
                                <input class="input" type="email" name="email" placeholder="Email" required>
                            </div>
                            @error('email')
                                <p class="validation-error">{{ $message }}</p>
                            @enderror
                            <div class="group">
                                <svg stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" class="icon">
                                    <path
                                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"
                                        stroke-linejoin="round" stroke-linecap="round"></path>
                                </svg>
                                <input class="input" type="password" name="password" placeholder="Password" required>
                            </div>
                            @error('password')
                                <p class="validation-error">{{ $message }}</p>
                            @enderror
                        </div>
                        @if (session('danger'))
                            <div class="mb-4">
                                <ul class="error">
                                    {{ session('danger') }}
                                </ul>
                            </div>
                        @endif
                        <div class="col-lg-12">
                            <button class="login_btn"> Login</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
