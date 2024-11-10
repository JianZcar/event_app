document.addEventListener("DOMContentLoaded", function () {
  display_events();
});

function display_events() {
  var events = [];

  // Fetch events from database
  fetch("./../global_components/exec_calendar.php")
    .then((response) => response.json())
    .then((data) => {
      var result = data.data;
      result.forEach((event) => {
        events.push({
          id: event.event_id,
          title: event.subject_name,
          start: event.start_datetime,
          end: event.end_datetime,
          color: event.color,
          url: event.url,
        });
      });

      // Get the incoming 3 months of event
      var today = new Date();
      var next3Months = new Date(today);
      next3Months.setMonth(next3Months.getMonth() + 3);

      // Initialize FullCalendar
      var calendarEl = document.getElementById("calendar");

      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialDate: "2024-01-01",
        initialView: "timeGridWeek",
        nowIndicator: true,
        headerToolbar: {
          left: "prev,next today",
          center: "title",
          right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
        },
        navLinks: true,
        editable: true,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        events: events,
        select: function (start, end) {
          document.getElementById("event_start_date").value = start.startStr;
          document.getElementById("event_end_date").value = end.endStr;
          $("#event_entry_modal").modal("show");
        },
        eventClick: function (info) {
          alert(info.event.id);
        },
      });

      calendar.render();
    })
    .catch((error) => {
      console.error("Error fetching events:", error);
      alert("Error fetching events");
    });
}

function save_event() {
  var event_name = document.getElementById("event_name").value;
  var event_start_date = document.getElementById("event_start_date").value;
  var event_end_date = document.getElementById("event_end_date").value;

  if (event_name === "" || event_start_date === "" || event_end_date === "") {
    alert("Please enter all required details.");
    return false;
  }

  fetch("save_event.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      event_name: event_name,
      event_start_date: event_start_date,
      event_end_date: event_end_date,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      $("#event_entry_modal").modal("hide");
      if (data.status) {
        alert(data.msg);
        location.reload();
      } else {
        alert(data.msg);
      }
    })
    .catch((error) => {
      console.error("Error saving event:", error);
      alert("Error saving event");
    });

  return false;
}
