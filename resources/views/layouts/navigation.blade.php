@auth
    @include('layouts/navbar')
@endauth

@guest
<nav id="header" class="w-full z-30 top-10 py-1 bg-white shadow-lg border-b border-gray-700">
    <div class="w-full flex items-center justify-between mt-0 px-6 py-2">

        <div class="hidden md:flex md:items-center md:w-auto w-full order-3 md:order-1" id="menu">
            <nav>
                <ul class="md:flex items-center justify-between text-base text-gray-500 pt-4 md:pt-0">
                    <li>
                        <a class="inline-block no-underline hover:text-black font-medium text-xl py-2 px-4 lg:-ml-2"
                            href="{{ route('dashboard') }}">
                            {{ __('SocialApp') }}
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="order-2 md:order-3 flex flex-wrap items-center mx-auto justify-end mr-0 md:mr-4" id="nav-content">
            <div class="auth flex items-center w-full md:w-full">
                <a href="{{ route('login') }}"
                    class="bg-transparent text-gray-800  p-2 rounded border border-gray-300 mr-4 hover:bg-gray-100 hover:text-gray-700">Login</a>
                <a href="{{ route('register') }}"
                    class="bg-gray-700 text-gray-200  p-2 rounded  hover:bg-gray-900 hover:text-gray-100">Register</a>
            </div>
        </div>
    </div>
</nav>
@endguest
