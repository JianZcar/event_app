CREATE TABLE IF NOT EXISTS users(
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(48),
  name VARCHAR(48),
  is_active BOOL,
  remarks TEXT,
  user_role INT
);

-- Trigger
CREATE DEFINER=`root`@`localhost` TRIGGER `users_AFTER_INSERT` AFTER INSERT ON `users` FOR EACH ROW BEGIN
  INSERT INTO user_infos(id) VALUES (NEW.id);
END