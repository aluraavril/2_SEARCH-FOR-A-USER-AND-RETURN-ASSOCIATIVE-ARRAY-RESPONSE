CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    birthday DATE NOT NULL,
    address TEXT NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    details TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);



CREATE TABLE applicants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    job_title VARCHAR(100) NOT NULL,
    skills TEXT NOT NULL,
    years_of_experience INT NOT NULL,
    status ENUM('Pending', 'Shortlisted', 'Rejected', 'Hired') DEFAULT 'Pending',
    added_by VARCHAR(100) NOT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO applicants (first_name, last_name, email, phone, address, job_title, skills, years_of_experience, status, added_by)
VALUES
('Juan', 'Dela Cruz', 'juan.delacruz@example.com', '09171112233', '45 Sunrise Ave, Bacoor, Cavite', 'Math Teacher', 'Algebra, Geometry', 5, 'Pending', 'Admin'),
('Maria', 'Santos', 'maria.santos@example.com', '09183334455', '67 Moonlight Blvd, Dasmariñas, Cavite', 'Science Teacher', 'Physics, Chemistry, Biology', 7, 'Shortlisted', 'Admin'),
('Jose', 'Reyes', 'jose.reyes@example.com', '09224445566', '12 Elmwood St, Tagaytay', 'English Teacher', 'Grammar, Literature, Writing', 3, 'Hired', 'Admin'),
('Ana', 'Lopez', 'ana.lopez@example.com', '09335556677', '89 Oakridge Dr, General Trias', 'History Teacher', 'World History, Philippine History', 6, 'Rejected', 'Admin'),
('Carlos', 'Garcia', 'carlos.garcia@example.com', '09446667788', '23 Pinecrest Rd, Silang', 'PE Teacher', 'Physical Fitness, Sports', 4, 'Pending', 'Admin'),
('Liza', 'Martinez', 'liza.martinez@example.com', '09557778899', '54 Maple Ave, Taguig', 'Music Teacher', 'Singing, Piano, Guitar', 8, 'Pending', 'Admin'),
('Ramon', 'Bautista', 'ramon.bautista@example.com', '09668889900', '88 Bamboo St, Cavite City', 'Art Teacher', 'Drawing, Painting, Sculpture', 10, 'Shortlisted', 'Admin'),
('Isabel', 'Diaz', 'isabel.diaz@example.com', '09779990011', '22 Oakwood Rd, Pasig', 'Computer Science Teacher', 'Programming, Data Structures', 2, 'Pending', 'Admin'),
('Eduardo', 'Mendoza', 'eduardo.mendoza@example.com', '09881111222', '33 Sunset Blvd, Manila', 'Social Studies Teacher', 'Geography, Civics, Sociology', 6, 'Hired', 'Admin'),
('Carmen', 'Valencia', 'carmen.valencia@example.com', '09992223344', '14 Coconut St, Davao', 'Special Education Teacher', 'Autism Spectrum, Learning Disabilities', 4, 'Rejected', 'Admin');
