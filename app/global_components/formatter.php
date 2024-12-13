<?php
function page_full_name() {
    /**
     * Page title
     *
     * @param string $title Page title
     */
    global $page_name, $proj_name;
    return "$page_name | $proj_name"; 
}

function date_post($date, $format_mode, $words_bool) {
    /**
     * Format date with relative time
     *
     * @param string $date        Date to be formatted
     * @param string $format_mode Format mode of the date
     * @param bool   $words_bool  Show relative time or formatted date
     *
     * @return string Formatted date
     */
    $current_date = new DateTime();
    $input_date = new DateTime($date);
    $interval = $current_date->diff($input_date);

    if ($words_bool) {
        $units = [
            'y' => 'year',
            'm' => 'month',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];

        foreach ($units as $unit => $name) {
            $value = $interval->$unit;
            if ($value > 0) {
                return $value . ' ' . $name . ($value > 1 ? 's' : '') . ' ago';
            }
        }

        return 'Just now';
    } else {
        return date($format_mode, strtotime($date));
    }
}

// Checking if the date is "Incoming", "Past", or "Ongoing"


function date_status($start_date, $end_date) {
    /**
     * Get date status (Incoming, Ongoing, Past)
     *
     * @param string $start_date Start date and time
     * @param string $end_date   End date and time
     *
     * @return string Date status
     */
    $current_date = new DateTime();
    $start_date = new DateTime($start_date);
    $end_date = new DateTime($end_date);

    if ($current_date < $start_date) {
        return "Incoming";
    } elseif ($current_date >= $start_date && $current_date <= $end_date) {
        return "Ongoing";
    } else {
        return "Past";
    }
}

function date_and_time_status($start_date, $end_date) {
    /**
    * Get date and time status (Incoming, Today, Ongoing, Past)
    *
    * @param string $start_date Start date and time
    * @param string $end_date   End date and time
    *
    * @return string Date and time status
    */
    $current_date = new DateTime();
    $start_date = new DateTime($start_date);
    $end_date = new DateTime($end_date);

    if ($current_date < $start_date) {
        $status = "Incoming";
    } elseif ($current_date >= $start_date && $current_date <= $end_date) {
        if ($start_date->format('Y-m-d') === $end_date->format('Y-m-d')) {
            $status = "Today";
        } else {
            $status = "Ongoing";
        }
    } else {
        $status = "Past";
    }

    return $status;
}
?>