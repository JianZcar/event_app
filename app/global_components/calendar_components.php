<?php
function upcoming_display_calendar($event_data) {
    /**
     * Display upcoming events in calendar
     * @param array $event_data
     */

    //  for loop to display to the web

    // limit by first 40 events only
    foreach ($event_data as $event) {
        $event_id = $event['id'];
        $event_name = $event['subject_name'];
        $event_content = $event['content'];
        $event_start = $event['start_datetime'];
        $event_end = $event['end_datetime'];

        // Display the event
        echo "<div class=\"upcoming-list\" bis_skin_checked=\"1\">$event_name</div>";
    }
}
?>


<?php
function upcoming_event_show($event_data) {
    /**
     * Display upcoming events
     */
    ?>
    <div class="flex flex-row w-full p-3">
        <p class="bold">Upcoming Events in 3 months</p>
        <div class="text-sm font-light text-[#6B7280] pb-8" bis_skin_checked="1">"Mark Your Calendars": Simplify date remembering.</div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 px-1 py-1" bis_skin_checked="1">
            <?php 
            // event_data 
            if (is_array($event_data) && count($event_data) > 0) {
                foreach ($event_data as $event) {
                    $event_id = $event['id'];
                    $event_name = $event['subject_name'];
                    $event_content = $event['content'];
                    $event_start = $event['start_datetime'];
                    $event_end = $event['end_datetime'];

                    // Limiting the string $event_name up to 20 char its text only
                    if (strlen($event_name) > 20) {
                        $event_name = substr($event_name, 0, 20) . '...';
                    }

                    // Starting for today date up to 3 months
                    if ($event_start) {
                        $current_date = new DateTime();
                        $event_start_date = new DateTime($event_start);
                        $interval = $current_date->diff($event_start_date);
                        $months_difference = $interval->y * 12 + $interval->m;

                        if ($months_difference <= 3 && $event_start_date >= $current_date) {
                            // Display the event
                            echo "<div class=\"upcoming-list\" bis_skin_checked=\"1\">
                            $event_name
                            <p>$event_start - $event_end</p>
                            </div>";
                        }
                    }
                }
            }
            ?>
        </div>
    </div>
    <?php
}
?>
