<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <div class="flex flex-col justify-center items-center  font-semibold">
            <div class="text-6xl font-semibold text-primary tracking-wider flex flex-row items-center gap-2"><img
                    src="{{ asset('images/Logo.png') }}" alt="" class="w-20"> UPMYENGLISH</div>
            <div class="text-xl mt-6 text-third">ENGLISH LEARNING FOR ELEMENTARY SCHOOL STUDENTS</div>
            <div class="mt-8 w-full flex  items-end justify-end mr-20">
                <a href="/login" class="bg-primary text-white px-8 py-3 rounded-lg text-2xl flex flex-row items-center gap-2">
                    Get Started <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="-translate-y-10"><img src="{{ asset('images/background.png') }}" alt="" class="w-full z-10">
        </div>
    </div>
</body>

</html>
