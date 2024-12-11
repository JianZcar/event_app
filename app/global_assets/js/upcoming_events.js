$(document).ready(function () {
    display_events();
}); //end document.ready block

function display_events() {
    var events = new Array();

    // Fetch events from database

    $.ajax({
        url: "./../global_components/exec_calendar.php",
        dataType: "json",
        success: function (response) {
            var result = response.data;
            $.each(result, function (i) {
                events.push({
                    event_id: result[i].event_id,
                    title: result[i].title,
                    start: result[i].start,
                    end: result[i].end,
                    color: result[i].color,
                    url: result[i].url,
                });
            });

            // Initialize fullCalendar

            $("#calendar").fullCalendar({
                defaultView: "month",
                timeZone: "local",
                editable: true,
                selectable: true,
                selectHelper: true,
                select: function (start, end) {
                    $("#event_start_date").val(moment(start).format("YYYY-MM-DD"));
                    $("#event_end_date").val(moment(end).format("YYYY-MM-DD"));
                    $("#event_entry_modal").modal("show");
                },
                events: events,
                eventRender: function (event, element) {
                    element.bind("click", function () {
                        alert(event.event_id);
                    });
                },
            });

            //end fullCalendar block
        }