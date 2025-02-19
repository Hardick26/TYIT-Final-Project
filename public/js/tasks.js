document.addEventListener('DOMContentLoaded', function() {
    // Handle Complete Task button click
    const completeTaskModal = document.getElementById('completeTaskModal');
    if (completeTaskModal) {
        completeTaskModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const taskId = button.getAttribute('data-task-id');
            const taskTitle = button.getAttribute('data-task-title');
            
            const form = this.querySelector('#completeTaskForm');
            form.action = `/tasks/${taskId}/complete`;
            
            this.querySelector('.modal-title').textContent = `Complete Task: ${taskTitle}`;
        });
    }
}); 