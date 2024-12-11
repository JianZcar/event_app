import faker, pymysql

db_host = 'localhost'
db_user = 'root'
db_password = 'Day15@!'
db_name = 'event_app'

conn = pymysql.connect(host=db_host, user=db_user, password=db_password, db=db_name, charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)
cursor = conn.cursor()

fake = faker.Faker()

# Make a fake posts in 50 times
for _ in range(50):
    title = fake.sentence()
    content = fake.text()
    user_id = 1
    start_datetime = fake.date_time_this_year()
    end_datetime = fake.date_time_this_year()
    cursor.execute(f"INSERT INTO event_posts (subject_name, content, user_id, start_datetime, end_datetime) VALUES ('{title}', '{content}', {user_id}, '{start_datetime}', '{end_datetime}')")
    conn.commit()
