<?php
function merge_datetime($date, $time) {
    /**
     * Merge date and time
     *
     * @param string $date Date
     * @param string $time Time
     * @return string Date and time
     */
    $datetime = date("Y-m-d H:i:s", strtotime("$date $time"));
    return $datetime;
}
?>


<?php
function date_picker($datetime, $varname, $date_label = NULL) {
    /**
     * Date and time picker
     *
     * @param string $datetime Date and time
     * @param string $varname  Variable name
     * @return string Date and time picker
     */
    $date = date("Y-m-d", strtotime($datetime));
    $time = date("H:i", strtotime($datetime));
    if (empty($date_label)) {
        $date_label = "Set date:";
    }
    if (empty($varname)) {
        $varname = "date";
    }
    ?>
    
    <div class="relative max-w-sm w-full md:w-1/2">
        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 text-center dark:text-white"><?php echo $date_label?></label>
        <input name="<?php echo $varname?>" id="<?php echo $varname?>" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full focus:ring-blue-500 focus:border-blue-500 block ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<?php echo $date_label?>" value="<?php echo $date; ?>" onclick="this.type='date'" onblur="formatDate(this)">
    </div>
    
    <script>
    function formatDate(input) {
        if (input.type === 'date') {
            const date = new Date(input.value);
            const formattedDate = date.toISOString().split('T')[0];
            input.type = 'text';
            input.value = formattedDate;
        }
    }
    </script>
<?php
    return $datetime;
}
?>

<?php
function time_picker($datetime, $varname, $time_label = NULL) {
    /**
     * Time picker
     *
     * @param string $datetime Date and time
     * @param string $time_label Time label
     * @return string Time picker
     */
    $time = date("H:i", strtotime($datetime));
    if (empty($time_label)) {
        $time_label = "Set time:";
    }
    if (empty($varname)) {
        $varname = "time";
    }
?>
    <div class="w-full justify-items-center md:w-1/2">
        <label for="time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><?php echo $time_label?></label>
        <div class="relative">
            <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10-10-10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                </svg>
            </div>
            <input type="time" name="<?php echo $varname?>" id="<?php echo $varname?>"  class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?php echo $time; ?>" required />
        </div>
    </div>
<?php
    return $time;
}
?>