<div
    id="sign-in-dialog-backdrop"
    data-dialog-backdrop="sign-in-dialog"
    data-dialog-backdrop-close="true"
    class="pointer-events-none fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300"
>
    <div
        id="sign-in-dialog"
        data-dialog="sign-in-dialog"
        class="relative mx-auto w-full max-w-[24rem] rounded-lg overflow-hidden shadow-sm"
    >
        <div class="relative flex flex-col bg-white">
            <div class="relative m-2.5 items-center flex justify-center text-white h-24 rounded-md bg-slate-800">
                <h3 class="text-2xl">
                    Sign In
                </h3>
            </div>
            <div class="p-6 pt-0">
                <button class="w-full rounded-md bg-slate-800 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                    Sign In
                </button>
                <p class="flex justify-center mt-6 text-sm text-slate-600">
                    Don&apos;t have an account?
                    <a href="#signup" class="ml-1 text-sm font-semibold text-slate-700 underline">
                        Sign up
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>