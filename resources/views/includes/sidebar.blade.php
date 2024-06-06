<div class="flex flex-col h-full justify-between text-gray-600">
    <ul class="flex flex-col gap-4 menu text-base">
        <li
            class="{{ request()->is('admin/dashboard*') ? 'bg-primary text-white' : '' }} py-2 px-6 rounded-md  hover:bg-primary hover:text-white transition">
            <a href="/admin/dashboard" class="p-0"><i class="fa-solid fa-house pr-1"></i> Dashboard</a>
        </li>
        <li
            class="{{ request()->is('admin/materi*') ? 'bg-primary text-white' : '' }} py-2 px-6 rounded-md  hover:bg-primary hover:text-white transition">
            <a href="/admin/materi" class="p-0"><i class="fa-solid fa-book pr-1"></i> Materi</a>
        </li>
        <li
            class="{{ request()->is('admin/submateri*') ? 'bg-primary text-white' : '' }} py-2 px-6 rounded-md  hover:bg-primary hover:text-white transition">
            <a href="/admin/submateri" class="p-0"><i class="fa-solid fa-book-open-reader pr-1"></i> Sub Materi</a>
        </li>
        <li
            class="{{ request()->is('admin/question*') ? 'bg-primary text-white' : '' }} py-2 px-6 rounded-md  hover:bg-primary hover:text-white transition">
            <a href="/admin/question" class="p-0"><i class="fa-solid fa-clipboard-question pr-1"></i> Pertanyaan</a>
        </li>
        <li
            class="{{ request()->is('admin/user-answer*') ? 'bg-primary text-white' : '' }} py-2 px-6 rounded-md  hover:bg-primary hover:text-white transition">
            <a href="/admin/user-answer" class="p-0"><i class="fa-solid fa-user pr-1"></i> Jawaban User</a>
        </li>
    </ul>
    <div>
        <ul>
            <li class="py-2 rounded-md px-6 hover:bg-red-500 hover:text-white  transition">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                        class="fa-solid fa-right-from-bracket pr-1"></i> Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
