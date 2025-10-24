-- Database: db_manajemen_proyek

CREATE DATABASE IF NOT EXISTS db_manajemen_proyek;
USE db_manajemen_proyek;

-- Table: users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Super Admin', 'Project Manager', 'Team Member') NOT NULL,
    project_manager_id INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_role (role),
    INDEX idx_project_manager_id (project_manager_id),
    FOREIGN KEY (project_manager_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Table: projects
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_proyek VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    manager_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_manager_id (manager_id),
    INDEX idx_nama_proyek (nama_proyek),
    FOREIGN KEY (manager_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table: tasks
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_tugas VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    status ENUM('belum', 'proses', 'selesai') DEFAULT 'belum',
    project_id INT NOT NULL,
    assigned_to INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_project_id (project_id),
    INDEX idx_assigned_to (assigned_to),
    INDEX idx_status (status),
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL
);

-- Insert default users (passwords are hashed versions of 'password')
INSERT INTO users (username, password, role) VALUES 
('superadmin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Super Admin'), -- password: password
('pm1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Project Manager'), -- password: password
('tm1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Team Member'), -- password: password
('tm2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Team Member'); -- password: password

-- Link team members to project manager
UPDATE users SET project_manager_id = 2 WHERE id IN (3, 4);

-- Create a sample project
INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES 
('Website Development', 'Developing a company website', '2025-01-01', '2025-04-01', 2);

-- Create sample tasks
INSERT INTO tasks (nama_tugas, deskripsi, project_id, assigned_to) VALUES 
('Design Homepage', 'Create homepage design mockup', 1, 3),
('Implement Backend', 'Develop backend API', 1, 4),
('Testing', 'Test the website functionality', 1, 3);