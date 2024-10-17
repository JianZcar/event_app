CREATE TABLE IF NOT EXISTS users(
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(48),
  name VARCHAR(48),
  is_active BOOL,
  remarks TEXT,
  user_role INT
);