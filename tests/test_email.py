import smtplib

sender = "Private Person <hello@demomailtrap.com>"
receiver = "A Test User <markcediebuday@gmail.com>"

message = f"""\
Subject: Hi Mailtrap
To: {receiver}
From: {sender}

This is a test e-mail message."""

with smtplib.SMTP("live.smtp.mailtrap.io", 587) as server:
    server.starttls()
    server.login("api", "4e204e380fe30781a610e520a186107e")
    server.sendmail(sender, receiver, message)