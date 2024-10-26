
function modal_DeleteAccount(username) {
    const modalHTML = `
        <div
            id="modal-delete-account"
            data-dialog-backdrop="sign-in-dialog"
            data-dialog-backdrop-close="true"
            class="fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300 pointer-events-none opacity-0"
        >
            <div
                id="sign-in-dialog"
                data-dialog="sign-in-dialog"
                class="relative mx-auto w-full max-w-[24rem] rounded-lg overflow-hidden shadow-sm">
                <div class="relative flex flex-col bg-white">

                    <div class="modal-panel-1 bg-red-700 text-white">
                        <h3 class="text-4xl">
                        <i class='bx bx-trash'></i>
                        </h3>
                    </div>
                    <div class="modal-panel-1 h-5">
                    Do you want to delete${username}?
                    </div>
                    
                    <div class="p-6 pt-0">
                        <button class="btn-post-danger-1" type="button">Delete</button>
                        <button id="close-dialog-btn" class="btn-post-common-1" type="button">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    `

    // How about show and hide
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    let modal_btn_close = document.querySelector('#close-dialog-btn');
    // let modal_btn_delete = document.querySelector('#delete-account-btn');
    let modal_dialog = document.querySelector('#modal-delete-account');

    modal_btn_close.addEventListener('click', function() {
        modal_dialog.classList.toggle('pointer-events-none');
        modal_dialog.classList.toggle('opacity-0');
        modal_dialog.classList.toggle('hidden');
    });

}

















function modal_DeleteAccount(username) {

    let modal_dialog_html = `
        <div
            id="modal-delete-account"
            data-dialog-backdrop="sign-in-dialog"
            data-dialog-backdrop-close="true"
            class="fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300 pointer-events-none opacity-0"
        >
            <div
                id="sign-in-dialog"
                data-dialog="sign-in-dialog"
                class="relative mx-auto w-full max-w-[24rem] rounded-lg overflow-hidden shadow-sm">
                <div class="relative flex flex-col bg-white">

                    <div class="modal-panel-1 bg-red-700 text-white">
                        <h3 class="text-4xl">
                            <i class='bx bx-trash'></i>
                        </h3>
                    </div>
                    <div class="modal-panel-1 h-5">
                    Do you want to delete <?php echo $username?>?
                    </div>
                    
                    <div class="p-6 pt-0">
                        <button class="btn-post-danger-1" type="button">Delete</button>
                        <button id="close-dialog-btn" class="btn-post-common-1" type="button">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modal_dialog_html);

    let modal_btn_open = document.querySelector('#open-dialog-btn');
    let modal_dialog = document.querySelector('#modal-delete-account');
    let modal_btn_close = document.querySelector('#close-dialog-btn');
    
    modal_btn_open.addEventListener('click', function() {
        modal_dialog.classList.toggle('pointer-events-none');
        modal_dialog.classList.toggle('opacity-0');
    });
    
    modal_btn_close.addEventListener('click', function() {
        modal_dialog.classList.toggle('pointer-events-none');
        modal_dialog.classList.toggle('opacity-0');
    });
};
