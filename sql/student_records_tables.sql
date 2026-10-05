CREATE TABLE IF NOT EXISTS borrows (
    borrow_id INT AUTO_INCREMENT PRIMARY KEY,
    student_number VARCHAR(20) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    book_title VARCHAR(150) NOT NULL,
    borrow_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE NULL
);
 
CREATE TABLE IF NOT EXISTS penalties (
    penalty_id INT AUTO_INCREMENT PRIMARY KEY,
    student_number VARCHAR(20) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    reason VARCHAR(255) NOT NULL,
    amount DECIMAL(8,2) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'unpaid'
);