CREATE TABLE IF NOT EXISTS user_infos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  bio TEXT,
  profile_picture BLOB,
  profile_cover BLOB,
  FOREIGN KEY (id) REFERENCES users(id)
);