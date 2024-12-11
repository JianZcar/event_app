<?php
function global_header($page_name) {
?>
    <header class="navigator-header btn-slide">
        <a class="p-2 text-2xl hover-action" id="btn-menu-list" onclick="slideOpen()"><i class='bx bx-menu'></i></a>
        <h1 class="p-2 text-2xl"><?php echo $page_name ?></h1>
    </header>
<?php
}
?>