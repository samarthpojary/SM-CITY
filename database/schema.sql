-- MySQL schema for SM City
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('citizen','officer','admin') NOT NULL DEFAULT 'citizen',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_users_email (email),
  INDEX idx_users_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS complaints (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(200) NOT NULL,
  description TEXT NOT NULL,
  category ENUM('Garbage','Road/Pothole','Water Leakage','Drainage','Streetlight','Uncategorized') NOT NULL DEFAULT 'Uncategorized',
  priority ENUM('Low','Medium','High') NOT NULL DEFAULT 'Low',
  status ENUM('Submitted','In Progress','On Hold','Resolved','Rejected') NOT NULL DEFAULT 'Submitted',
  latitude DECIMAL(10,7) NOT NULL,
  longitude DECIMAL(10,7) NOT NULL,
  image_path VARCHAR(255) NULL,
  resolution_proof VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  resolved_at DATETIME NULL,
  CONSTRAINT fk_complaints_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT chk_latitude_range CHECK (latitude >= -90 AND latitude <= 90),
  CONSTRAINT chk_longitude_range CHECK (longitude >= -180 AND longitude <= 180)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Indexes for performance and geo queries
CREATE INDEX idx_complaints_user ON complaints(user_id);
CREATE INDEX idx_complaints_status ON complaints(status);
CREATE INDEX idx_complaints_category ON complaints(category);
CREATE INDEX idx_complaints_priority ON complaints(priority);
CREATE INDEX idx_complaints_created ON complaints(created_at);
CREATE INDEX idx_complaints_geo ON complaints(latitude, longitude);
CREATE INDEX idx_complaints_status_category ON complaints(status, category);
CREATE INDEX idx_complaints_user_status ON complaints(user_id, status);
