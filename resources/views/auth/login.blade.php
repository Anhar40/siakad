<x-guest-layout>
    
    <div class="fixed inset-0 z-[-1] overflow-hidden">
        <img src="https://unswa.ac.id/wp-content/uploads/2023/12/DSC_0027-scaled.jpg" 
             class="w-full h-full object-cover" 
             alt="Background">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-[1px]"></div>
    </div>

    <div class="min-h-screen flex flex-col justify-center items-center p-4">
        <div class="w-full max-w-md">
            
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl shadow-2xl rounded-3xl overflow-hidden border border-white/20 transition-all duration-300">
                
                <div class="p-8 sm:p-10">
                    <div class="text-center mb-10">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-siakad-primary rounded-2xl shadow-lg mb-4 text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0020 13c0-2.254-.57-4.372-1.582-6.213M17.222 5.732A10.003 10.003 0 005.204 15.019m9.293-9.293A10.012 10.012 0 0116.15 8.312M7 10h.01M9 21h6m-1-4l1 1m-1-1l-1 1m-4-1l1 1m-1-1l-1 1"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                            Welcome Back
                        </h2>
                        <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                            Please sign in to access your dashboard
                        </p>
                    </div>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div class="space-y-1">
                            <x-input-label for="email" :value="__('Email')" class="ml-1 text-xs font-semibold uppercase tracking-wider text-gray-500" />
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-siakad-primary transition-colors duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <input id="email" 
                                    class="block w-full pl-11 pr-4 py-3 bg-white/50 dark:bg-gray-800/50 border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100 rounded-2xl focus:ring-2 focus:ring-siakad-primary/50 focus:border-siakad-primary transition-all duration-200 outline-none placeholder-gray-400 text-sm" 
                                    type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@company.com" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <div class="space-y-1">
                            <x-input-label for="password" :value="__('Password')" class="ml-1 text-xs font-semibold uppercase tracking-wider text-gray-500" />
                            <div class="relative group" x-data="{ show: false }">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-siakad-primary transition-colors duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input id="password" 
                                    class="block w-full pl-11 pr-12 py-3 bg-white/50 dark:bg-gray-800/50 border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100 rounded-2xl focus:ring-2 focus:ring-siakad-primary/50 focus:border-siakad-primary transition-all duration-200 outline-none placeholder-gray-400 text-sm" 
                                    :type="show ? 'text' : 'password'" name="password" required placeholder="••••••••" />
                                
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-siakad-primary transition-colors focus:outline-none">
                                    <svg class="h-5 w-5" x-show="!show" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    <svg class="h-5 w-5" x-show="show" style="display:none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.577-2.387M8 8.05A2.992 2.992 0 007.828 10.828l3.125 3.125a2.991 2.991 0 003.354-.055m1.515-2.074a2.992 2.992 0 00-.776-3.875" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" /></svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                                <input id="remember_me" type="checkbox" class="rounded-md border-gray-300 text-siakad-primary shadow-sm focus:ring-siakad-primary/20 dark:bg-gray-800 dark:border-gray-700" name="remember">
                                <span class="ml-2 text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-200 transition-colors">Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm font-semibold text-siakad-primary hover:text-siakad-dark transition-colors" href="{{ route('password.request') }}">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-siakad-primary hover:bg-siakad-dark text-white font-bold py-3.5 px-4 rounded-2xl shadow-lg shadow-siakad-primary/30 transform transition-all duration-200 hover:-translate-y-0.5 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-siakad-primary focus:ring-offset-2">
                                Sign In
                            </button>
                        </div>
                    </form>

                    <div class="mt-10 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Having trouble? 
                            <a href="#" class="font-bold text-siakad-primary hover:underline transition-all">Contact Support</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>