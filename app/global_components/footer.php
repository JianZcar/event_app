<?php
function global_footer() {
    global $proj_name;
    global $proj_version;
    global $proj_author;
    global $proj_current_year;
?>  
    <footer class="bg-gray-800 text-white p-4 p-footer" id="p-footer">
        <p>All rights reserved <?php echo $proj_current_year ?></p>
    </footer>
<?php
}
?>