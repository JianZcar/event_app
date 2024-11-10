<?php
function post_subject_name($subject_name, $post_status, $created_at) {
?>
<div class="p-base flex flex-col">
    <div class="flex flex-row">
        <span class="bg-blue-600 text-white px-2 border-2 border-blue-400 mr-5"><?php echo $post_status ?></span>
        <h1 class="font-bold text-xl"><?php echo $subject_name ?></h1>
    </div>
    <p><?php echo $created_at ?></p>
</div>
<?php
}
?>

<?php
function post_content($start_datetime, $end_datetime, $content) {
?>
<div class="p-2">
    <p>Start: <?php echo $start_datetime ?></p>
    <p>End: <?php echo $end_datetime ?></p>
    <br>
    <p><?php echo $content ?></p>
</div>
<br>
<?php
}
?>

<?php
function post_actions($post_id) {
?>
<div>
    <a href="./edit_posts.php?id=<?php echo $post_id ?>">
        <i class='bx bx-edit-alt font-bold text-2xl dark:hover:bg-slate-100 dark:hover:text-slate-950'></i>
    </a>
</div>
<?php
}
?>

<?php
function post_actions_2($post_id) {
?>
<div class="p-base space-x-0 flex flex-col md:flex-row md:space-x-2">
    <a href="./send_post.php?id=<?php echo $post_id ?>" class="btn-post-accept-1">Invite</a>
    <!-- Edit post -->
    <a href="./edit_post.php?id=<?php echo $post_id ?>" class="btn-post-common-1">Edit Post</a>
    <a class="btn-post-danger-1">Delete</a>
</div>
<?php
}
?>

<?php
function tinymce_js_init() {
?>
<script src="./../../node_modules/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        height: 500,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
</script>
<?php
}
?>

<?php
function post_edit_subject_name($subject_name) {
?>
<div class="p-base flex flex-col">
    <!-- <input type="hidden" name="post_id" value="<?php echo $post_id ?>"> -->
    <input type="text" name="subject_name" class="p-textbox" value="<?php echo $subject_name ?>" placeholder="<?php echo $subject_name?>">
</div>
<?php
}
?>

<?php
function post_edit_content($content, $start_datetime, $end_datetime) {
?>
<div class="p-base">
    <div class="p-4">
        <div class="grid grid-cols-1 grid-rows-2">
            <div class="flex flex-row">
                <?php
                $set_start_time = time_picker($start_datetime, "start_time", "Start Time:");
                $set_start_date = date_picker($start_datetime, "start_date", "Start Date:");
                ?>
            </div>
            <div class="flex flex-row">
                <?php
                $set_end_time = time_picker($end_datetime, "end_time", "End Time:");
                $set_end_date = date_picker($end_datetime, "end_date", "End Date:");
                ?>
            </div>
        </div>
    </div>
    <div>
    <textarea id="content" name="content">
        <?php echo $content ?>
    </textarea>
</div>
</div>

<?php
}
?>

<?php 
function post_edit_actions($post_id) {
?>
<div class="p-base space-x-0 flex flex-col md:flex-row md:space-x-2">
    <button type="submit" class="btn-post-accept-1">Save</button>
    <a href="./view_posts.php?id=<?php echo $post_id ?>" class="btn-post-common-1">Cancel</a>
    <a class="btn-post-danger-1">Delete</a>
</div>
<?php
}
?>
