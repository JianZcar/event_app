CREATE TABLE IF NOT EXISTS users (
  id INT IDENTITY(1,1) PRIMARY KEY,
  username VARCHAR(48),
  name VARCHAR(48),
  is_active BIT,
  remarks TEXT,
  user_role INT,
  created_at datetime2 DEFAULT GETDATE(),
  updated_at datetime2 DEFAULT GETDATE()
);

-- updated_at TRIGGER AFTER_UPDATE
CREATE TRIGGER updated_at ON users
AFTER UPDATE
AS
BEGIN
  UPDATE users
  SET updated_at = GETDATE()
  FROM users
  INNER JOIN inserted ON users.id = inserted.id;
END;

-- Trigger
CREATE DEFINER=`root`@`localhost` TRIGGER `users_AFTER_INSERT` AFTER INSERT ON `users` FOR EACH ROW BEGIN
  INSERT INTO user_infos(id) VALUES (NEW.id);
END