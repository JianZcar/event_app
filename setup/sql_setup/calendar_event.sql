CREATE TABLE IF NOT EXISTS event_data (
  event_id INT auto_increment primary key,
  event_name varchar(255),
  event_start_date date default null,
  event_end_date date default null
)ENGINE=InnoDB DEFAULT CHARSET=latin1;