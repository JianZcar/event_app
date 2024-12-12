<?php
ob_start(); // Start output buffering

function import_jquery() {
    ?>
    <script src="./../../node_modules/jquery/dist/jquery.min.js"></script>
    <?php
}

function global_style() {
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../global_assets/css/output.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <?php
}

function global_first_js() {
    ?>
    <script src="./../../node_modules/jquery/dist/jquery.min.js"></script>
    <?php
}

function global_last_js() {
    ?>
    <script src="../global_assets/js/sidebar.js"></script>
    <?php
}

ob_end_flush(); // End output buffering and flush the output
?>