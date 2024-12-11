<?php

function form_register() {
    /**
     * Register form - POST method
     */
?>
            <div class="p-base">
                <div class="flex flex-col w-full md:w-1/2 xl:w-2/5 2xl:w-2/5 3xl:w-1/3 mx-auto p-8 md:p-10 2xl:p-12 3xl:p-14 bg-[#ffffff] rounded-2xl shadow-xl">
                    <form class="flex flex-col" method="post">
                        <div class="pb-6">
                            <label for="username" class="block mb-2 text-sm font-medium text-[#111827]">Username</label>
                            <div class="relative text-gray-400">
                                <input type="text" name="username" id="username" class="p-textbox" placeholder="Username" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="pb-6">
                            <label for="password1" class="block mb-2 text-sm font-medium text-[#111827]">Password</label>
                            <div class="relative text-gray-400">
                                <input type="password" name="password1" id="password" class="p-textbox" autocomplete="new-password" placeholder="Password">
                            </div>
                        </div>
                        <div class="pb-6">
                            <label for="password2" class="block mb-2 text-sm font-medium text-[#111827]">Confirm Password</label>
                            <div class="relative text-gray-400">
                                <input type="password" name="password2" id="password2" class="p-textbox" autocomplete="new-password" placeholder="Password">
                            </div>
                        </div>
                        <div class="pb-6">
                            <label for="email" class="block mb-2 text-sm font-medium text-[#111827]">Email</label>
                            <div class="relative text-gray-400">
                                <input type="email" name="email" id="email" class="p-textbox" placeholder="Email" autocomplete="off" value="">
                            </div>
                        </div>
                        <button type="submit" class="btn-post-accept-1">Add User</button>
                        <p class="text-gray-800 text-sm !mt-8 text-center">Already have an account?<a href="./index.php" class="text-blue-600 hover:underline ml-1 whitespace-nowrap font-semibold">Login here</a></p>
                    </form>
                </div>
            </div>
<?php
}
?>

<?php
function form_login() {
    /**
     * Login form - POST method
     */
?>
<div class="p-base">
    <div class="flex flex-col w-full md:w-1/2 xl:w-2/5 2xl:w-2/5 3xl:w-1/3 mx-auto p-8 md:p-10 2xl:p-12 3xl:p-14 bg-[#ffffff] rounded-2xl shadow-xl">
        <form class="flex flex-col" method="post">
            <div class="pb-6">
                <label for="username" class="block mb-2 text-sm font-medium text-[#111827]">Username</label>
                <div class="relative text-gray-400">
                    <input type="text" name="username" id="username" class="p-textbox" placeholder="Username" autocomplete="off" value="">
                </div>
            </div>

            <div class="pb-6">
                <label for="password" class="block mb-2 text-sm font-medium text-[#111827]">Password</label>
                <div class="relative text-gray-400">
                    <input type="password" name="password" id="password" class="p-textbox" autocomplete="new-password" placeholder="Password">
                </div>
            </div>

            <button type="submit" class="btn-post-accept-1">Login</button>
            <p class="text-gray-800 text-sm !mt-8 text-center">Don't have account?<a href="./register.php" class="text-blue-600 hover:underline ml-1 whitespace-nowrap font-semibold">Register here</a></p>
        </form>
    </div>
</div>
<?php
}
?>

<?php
function login_navbar() {
    /**
     * Navbar for login page
     */
    global $page_full_name;
?>
<header class="navigator-header btn-slide"> 
    <h1 class="p-2 text-2xl"><?php echo $page_full_name ?></h1>
</header>
<?php
}
?>
