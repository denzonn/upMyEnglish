<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')
</head>

<body>
    <div
        class="grid grid-cols-2 h-screen w-[100vw] justify-center items-center bg-gray-100 overflow-hidden relative z-20">
        <div
            class="absolute top-0 left-10 -translate-y-32 w-[120vw] h-screen -rotate-8 bg-backPrimary rounded-bl-[100px] -z-10">
        </div>
        <div class="absolute top-0 right-2 -translate-y-24  w-[30vw] h-[30vh] -rotate-8 bg-secondary rounded-3xl -z-10">
        </div>
        <div class="flex flex-col justify-center items-center font-semibold -translate-y-10">
            <div class="text-6xl font-semibold text-primary tracking-wider flex flex-row items-center gap-2"><img
                    src="{{ asset('images/Logo.png') }}" alt="" class="w-20"> UPMYENGLISH</div>
            <div class="w-full px-40 mt-4">
                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="text-third block text-xl font-bold mb-2">
                            Email
                        </label>
                        <input id="email" type="email"
                            class="bg-transparent border-login rounded-md w-full px-4 py-[10px] text-base font-medium @error('email') is-invalid @enderror"
                            placeholder="Email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <span class="invalid-feedback font-medium text-red-500 mb-4" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="password" class="text-third block text-xl font-bold mb-2">
                            Password
                        </label>
                        <input id="password" type="password"
                            class="bg-transparent border-login rounded-md w-full px-4 py-[10px] text-base font-medium @error('password') is-invalid @enderror"
                            placeholder="Password" name="password">
                        @error('password')
                            <span class="invalid-feedback font-medium text-red-500  mb-4" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mt-10">
                        <button type="submit"
                            class="bg-primary text-white px-4 py-[10px] w-full rounded-lg font-semibold text-lg">LOGIN</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="-translate-y-10"><img src="{{ asset('images/background.png') }}" alt="" class="w-full z-10">
        </div>
    </div>
</body>

</html>
