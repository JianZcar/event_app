create table if not exists event_posts(
    id int auto_increment primary key,
    subject_name varchar(255),
    content text,
    start_date datetime,
    end_time datetime,
    user_id int
);
