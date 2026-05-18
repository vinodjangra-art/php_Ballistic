$(document).ready(function(e) {
    // Handle edit button click
    $(document).on('click', '.edit-btn', function(e) {
        e.preventDefault();
        var courseId = $(this).data('course-id');
        console.log("Edit clicked for course:", courseId);
        
        $.ajax({
            url: '../php/editCourse.php',
            type: 'POST',
            dataType: 'json',
            data: { courseId: courseId },
            success: function(response) {
                if(response.status === 'success') {
                    let course = response.data;
                    showEditModal(course);
                    
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(error) {
                console.error('AJAX Error:', error);
                alert('Error loading course');
            }
        });
    });

    // Close modal
    $(document).on('click', '.close-modal', function() {
        $('#editModal').remove();
    });

    // Close modal when clicking outside
    $(document).on('click', '#editModal', function(e) {
        if(e.target.id === 'editModal') {
            $(this).remove();
        }
    });
});


function showEditModal(course) {
    let modalHtml = `
        <div id="editModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-[#0E295A] border border-[#215A9C] rounded-2xl p-8 max-w-md w-full mx-4">
                <h2 class="text-2xl flex justify-center font-bold text-[#FED50A] mb-6">Edit Course</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">Title</label>
                        <input type="text" id="editTitle" value="${course.title}" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>
                    
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">Description</label>
                        <textarea id="editDesc" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1 h-24">${course.description}</textarea>
                    </div>
                    
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">Price</label>
                        <input type="number" id="editPrice" value="${course.price}" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>
                    
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">Level</label>
                        <input type="text" id="editLevel" value="${course.level}" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>
                </div>
                
                <div class="flex gap-3 mt-6">
                    <button class="flex-1 bg-[#57A6DA] hover:brightness-110 text-white font-semibold py-2 rounded-lg transition" onclick="saveCourse(${course.id})">
                        Save
                    </button>
                    <button class="flex-1 close-modal bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 rounded-lg transition">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    `;
    
    $('body').append(modalHtml);
}

function saveCourse(courseId) {
    let title = $('#editTitle').val();
    let description = $('#editDesc').val();
    let price = $('#editPrice').val();
    let level = $('#editLevel').val();
    
    $.ajax({
        url: '../php/updateCourse.php',
        type: 'POST',
        dataType: 'json',
        data: { 
            courseId: courseId,
            title: title,
            description: description,
            price: price,
            level: level
        },
        success: function(response) {
            if(response.status === 'success') {
                alert('Course updated successfully');
                location.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(error) {
            console.error('AJAX Error:', error);
            alert('Error saving course');
        }
    });
}

