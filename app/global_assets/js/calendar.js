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
    }, //end success block
    error: function () {
      alert(response.msg);
    },
  }); //end ajax block
}

function save_event() {
  var event_name = $("#event_name").val();
  var event_start_date = $("#event_start_date").val();
  var event_end_date = $("#event_end_date").val();
  if (event_name == "" || event_start_date == "" || event_end_date == "") {
    alert("Please enter all required details.");
    return false;
  }
  $.ajax({
    url: "save_event.php",
    type: "POST",
    dataType: "json",
    data: {
      event_name: event_name,
      event_start_date: event_start_date,
      event_end_date: event_end_date,
    },
    success: function (response) {
      $("#event_entry_modal").modal("hide");
      if (response.status == true) {
        alert(response.msg);
        location.reload();
      } else {
        alert(response.msg);
      }
    },
    error: function (xhr) {
      console.log("ajax error = " + xhr.statusText);
      alert(response.msg);
    },
  });
  return false;
}
