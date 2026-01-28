<?php
require_once("../config/db.php");
?>
<?php include("../includes/header.php"); ?>

<div class="dashboard">
    <div class="dashboard-header">
        <div class="header-left">
            <h2><i class="fas fa-user-graduate"></i> Students Available</h2>
            <p class="subtitle">Manage all student records in one place</p>
        </div>
        <button class="btn-primary" onclick="openModal('add_student_modal')">
            <i class="fas fa-plus-circle"></i> Add New Student
        </button>
    </div>
    
    <div class="controls">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="search_btn" placeholder="Search students by name or ID...">
        </div>
        <div class="filter-box">
            <label for="filter"><i class="fas fa-filter"></i> Filter by:</label>
            <select name="filter" id="filter">
                <option value="all">All Students</option>
                <option value="name">Name</option>
                <option value="id">ID</option>
                <option value="class">Class</option>
            </select>
        </div>
    </div>
    
    <div class="table-container">
        <table id="studentsTable">
            <thead>
                <tr>
                    <th>ID <i class="fas fa-sort"></i></th>
                    <th>Name <i class="fas fa-sort"></i></th>
                    <th>Class <i class="fas fa-sort"></i></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="studentsTableBody">
                <!-- Data will be loaded via JavaScript -->
            </tbody>
        </table>
        <div class="table-loading" id="tableLoading">
            <i class="fas fa-spinner fa-spin"></i> Loading students...
        </div>
        <div class="no-data" id="noDataMessage" style="display: none;">
            <i class="fas fa-info-circle"></i> No students found. Add your first student!
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal" id="add_student_modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-user-plus"></i> Add New Student</h3>
            <button class="modal-close" onclick="closeModal('add_student_modal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="addStudentForm">
                <input type="hidden" name="action" value="add_student">
                <div class="form-group">
                    <label for="student_id"><i class="fas fa-id-card"></i> Student ID</label>
                    <input type="text" name="student_id" id="student_id" required 
                           placeholder="Enter student ID (e.g., STU001)">
                </div>
                <div class="form-group">
                    <label for="student_name"><i class="fas fa-user"></i> Student Name</label>
                    <input type="text" name="student_name" id="student_name" required 
                           placeholder="Enter full name">
                </div>
                <div class="form-group">
                    <label for="student_class"><i class="fas fa-school"></i> Student Class</label>
                    <input type="text" name="student_class" id="student_class" required 
                           placeholder="Enter class (e.g., Science or Arts)">
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal('add_student_modal')">
                        Cancel
                    </button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Save Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div class="modal" id="edit_student_modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-user-edit"></i> Edit Student</h3>
            <button class="modal-close" onclick="closeModal('edit_student_modal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="editStudentForm">
                <input type="hidden" name="action" value="update_student">
                <input type="hidden" name="student_id" id="edit_student_id">
                <div class="form-group">
                    <label for="edit_student_name"><i class="fas fa-user"></i> Student Name</label>
                    <input type="text" name="student_name" id="edit_student_name" required 
                           placeholder="Enter full name">
                </div>
                <div class="form-group">
                    <label for="edit_student_class"><i class="fas fa-school"></i> Student Class</label>
                    <input type="text" name="student_class" id="edit_student_class" required 
                           placeholder="Enter class">
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal('edit_student_modal')">
                        Cancel
                    </button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Update Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal" id="confirm_modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-exclamation-triangle"></i> Confirm Action</h3>
            <button class="modal-close" onclick="closeModal('confirm_modal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <p id="confirmMessage">Are you sure you want to delete this student?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeModal('confirm_modal')">
                Cancel
            </button>
            <button type="button" class="btn-danger" id="confirmAction">
                Confirm
            </button>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>