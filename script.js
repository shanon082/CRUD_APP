// Modal Functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = "flex";
    document.body.style.overflow = "hidden";
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = "none";
    document.body.style.overflow = "auto";
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = "none";
            document.body.style.overflow = "auto";
        }
    });
};

// Student Management Functions
let currentStudentId = null;

async function loadStudents() {
    const tableBody = document.getElementById('studentsTableBody');
    const loading = document.getElementById('tableLoading');
    const noData = document.getElementById('noDataMessage');
    
    tableBody.innerHTML = '';
    loading.style.display = 'block';
    noData.style.display = 'none';
    
    try {
        const response = await fetch('../data_processing/process_data.php?action=get_students');
        const result = await response.json();
        
        loading.style.display = 'none';
        
        if (result.success && result.data.length > 0) {
            result.data.forEach(student => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${student.Student_Id}</td>
                    <td>${student.Student_Name}</td>
                    <td>${student.Student_Class}</td>
                    <td class="actions">
                        <button class="btn-icon btn-edit" onclick="editStudent('${student.Student_Id}', '${student.Student_Name}', '${student.Student_Class}')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn-icon btn-delete" onclick="confirmDelete('${student.Student_Id}', '${student.Student_Name}')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        } else {
            noData.style.display = 'block';
        }
    } catch (error) {
        loading.style.display = 'none';
        showNotification('Error loading students: ' + error.message, 'error');
    }
}

function editStudent(id, name, className) {
    currentStudentId = id;
    document.getElementById('edit_student_id').value = id;
    document.getElementById('edit_student_name').value = name;
    document.getElementById('edit_student_class').value = className;
    openModal('edit_student_modal');
}

function confirmDelete(id, name) {
    currentStudentId = id;
    document.getElementById('confirmMessage').textContent = 
        `Are you sure you want to delete student "${name}" (ID: ${id})? This action cannot be undone.`;
    openModal('confirm_modal');
}

async function deleteStudent() {
    try {
        const formData = new FormData();
        formData.append('action', 'delete_student');
        formData.append('student_id', currentStudentId);
        
        const response = await fetch('../data_processing/process_data.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification('Student deleted successfully!', 'success');
            closeModal('confirm_modal');
            loadStudents();
        } else {
            showNotification(result.message, 'error');
        }
    } catch (error) {
        showNotification('Error deleting student: ' + error.message, 'error');
    }
}

// Form Handling
document.addEventListener("DOMContentLoaded", function() {
    // Load students on page load
    loadStudents();
    
    // Setup confirmation modal action
    document.getElementById('confirmAction').addEventListener('click', deleteStudent);
    
    // Add Student Form
    const addStudentForm = document.getElementById('addStudentForm');
    if (addStudentForm) {
        addStudentForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            submitBtn.disabled = true;
            
            try {
                const formData = new FormData(this);
                
                const response = await fetch('../data_processing/process_data.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification('Student added successfully!', 'success');
                    this.reset();
                    closeModal('add_student_modal');
                    loadStudents();
                } else {
                    showNotification(result.message, 'error');
                }
            } catch (error) {
                showNotification('Error adding student: ' + error.message, 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }
    
    // Edit Student Form
    const editStudentForm = document.getElementById('editStudentForm');
    if (editStudentForm) {
        editStudentForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            submitBtn.disabled = true;
            
            try {
                const formData = new FormData(this);
                
                const response = await fetch('../data_processing/process_data.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification('Student updated successfully!', 'success');
                    closeModal('edit_student_modal');
                    loadStudents();
                } else {
                    showNotification(result.message, 'error');
                }
            } catch (error) {
                showNotification('Error updating student: ' + error.message, 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }
    
    // Search functionality
    const searchInput = document.getElementById('search_btn');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#studentsTableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
    
    // Filter functionality
    const filterSelect = document.getElementById('filter');
    if (filterSelect) {
        filterSelect.addEventListener('change', function(e) {
            // Implement filtering logic here
            console.log('Filter changed to:', e.target.value);
        });
    }
});

// Notification System
function showNotification(message, type = 'info') {
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}