CREATE TABLE IF NOT EXISTS user_roles(
  id INT AUTO_INCREMENT PRIMARY KEY,
  role_name VARCHAR(30)
);

INSERT INTO user_roles(name) VALUES ('Administrator');
INSERT INTO user_roles(name) VALUES ('Member');