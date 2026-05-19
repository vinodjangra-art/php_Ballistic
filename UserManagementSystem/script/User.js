$(document).ready(function(e) {
    // Handle edit button click
    $(document).on('click', '.edit-btn', function(e) {
        e.preventDefault();
        var userId = $(this).data('user-id');
        console.log("Edit clicked for user:", userId);
        
        
        $.ajax({
            url: '../admin/edit.php',
            type: 'POST',
            dataType: 'json',
            data: { userId: userId },
            success: function(response) {
                if(response.status === 'success') {
       
                    let user= response.data;
                    showEditModal(user);
                    
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(error) {
                console.error('AJAX Error:', error);
                alert('Error loading user');
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
//handle delete button click
        $(document).on('click', '.dlt-user', function(e) {
            e.preventDefault();
        
            var userId = $(this).data('user-id');
            console.log("Delete clicked for user:", userId);
            
            if(confirm("Are you sure you want to delete this user?")) {
                $.ajax({
                    url: '../php/deleteUser.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: userId },
                    success: function(response) {   
                        if(response.status === 'success') {
                             alert('User deleted successfully');
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(error) {
                        console.error('AJAX Error:', error);
                        alert('Error deleting course');
                    }
                });
            }
        
        
        });

        //handle Add User button in Admin Dashboard
        $(document).on('click', '.add-user', function(e) {

            e.preventDefault();
            console.log("Add User button clicked");
            
            $.ajax({
                url: '../php/addUser.php',
                type: 'POST',
                dataType: 'json',
                data: { action: 'add' },
                success: function(response) {
                    if(response.status === 'success') {
                        showAddUserModal(response.data);
                        
                    } else {
                        alert('Error: ' + response.message);
                    }
                }

        }
    ); });
    
    function showEditModal(user) {
    let modalHtml = `
        <div id="editModal" class="fixed inset-0 bg-black-50 backdrop-blur-sm flex items-center justify-center ">
            <div class="bg-[#0E295A] border border-[#215A9C] rounded-2xl p-8 max-w-md w-full mx-4">
                <h2 class="text-2xl flex justify-center font-bold text-[#FED50A] mb-6">Edit User</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">First Name</label>
                        <input type="text" id="editFirstName" value="${user.firstName}" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>
                     <div class="space-y-4">
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">Last Name</label>
                        <input type="text" id="editLastName" value="${user.lastName}" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>
                     <div class="space-y-4">
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">Email</label>
                        <input type="email" id="editEmail" value="${user.email}" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>
                    
               
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">Phone Number</label>
                        <input type="number" id="editPhone" value="${user.phone}" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>
                    
                     <div class="space-y-4">
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">Address</label>
                        <input type="text" id="editAddress" value="${user.address}" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>
                    
                     <div>
                <label class="block text-[#ECEFF9] mb-2">
                    Gender
                </label>

                <select
                    name="gender"
                    id="editGender"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-[#ECEFF9] rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                >
                    <option value="">-- Please choose an option --</option>

            <option value="male" ${ user.gender == 'Male' ? "selected":""} >
            Male</option>
                    <option ${ user.gender == 'Female' ? "selected":""} 
                    value="female">Female</option>
                    <option ${ user.gender == 'Other' ? "selected":""} value="other">Other</option>
                </select>
            </div>
                  
                </div>
                
                <div class="flex gap-3 mt-6">
                    <button class="flex-1 bg-[#57A6DA] hover:brightness-110 text-white font-semibold py-2 rounded-lg transition" 
                    onclick="saveUser(${user.id})">
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

function saveUser(userId) {
    let firstName = $('#editFirstName').val();
    let lastName = $('#editLastName').val();
    let email = $('#editEmail').val();
    let phone = $('#editPhone').val();
    let address = $('#editAddress').val();
    let gender = $('#editGender').val();

    $.ajax({
        url: '../admin/updateUser.php',
        type: 'POST',
        dataType: 'json',
        data: { 
            userId: userId,
            firstName: firstName,
            lastName: lastName,
            email: email,
            phone: phone,
            address: address,
            gender: gender
        },
        success: function(response) {
            if(response.status === 'success') {
                alert('User updated successfully');
                location.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(error) {
            console.error('AJAX Error:', error);
            alert('Error saving user');
        }
    });
}

function showAddUserModal(user) {
    let modalHtml = `
        <div id="editModal" class="fixed inset-0 bg-black-50 backdrop-blur-sm flex items-center justify-center ">
            <div class="bg-[#0E295A] border border-[#215A9C] rounded-2xl p-8 max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
                <h2 class="text-2xl flex justify-center font-bold text-[#FED50A] mb-6">Add New User</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">Username</label>
                        <input type="text" id="addUsername" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>
                    
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">Password</label>
                        <input type="password" id="addPassword" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>
                    
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">First Name</label>
                        <input type="text" id="addFirstName" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>
                    
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">Last Name</label>
                        <input type="text" id="addLastName" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>
                    
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">Email</label>
                        <input type="email" id="addEmail" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>
                    
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">Phone Number</label>
                        <input type="number" id="addPhone" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>
                    
                    <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">Address</label>
                        <input type="text" id="addAddress" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>
                    
                    <div>
                        <label class="block text-[#ECEFF9] mb-2">Gender</label>
                        <select id="addGender" class="w-full bg-[#050C18] border border-[#4A4D53] text-[#ECEFF9] rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]">
                            <option value="">-- Please choose an option --</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-[#ECEFF9] mb-2">Role</label>
                        <select id="addRole" class="w-full bg-[#050C18] border 
                        border-[#4A4D53] text-[#ECEFF9] rounded-xl px-4 py-3 
                        focus:outline-none focus:ring-2 focus:ring-[#57A6DA]">
                            <option value="student">Student</option>
                            <option value="instructor">Instructor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                      <div>
                        <label class="text-[#A0A7B4] text-sm font-semibold">Profile Picture</label>
                        <input type="file" id="addProfilePicture" class="w-full bg-[#050C18] border border-[#215A9C] text-[#ECEFF9] px-3 py-2 rounded-lg mt-1">
                    </div>

                </div>
                
                <div class="flex gap-3 mt-6">
                    <button class="flex-1 bg-[#57A6DA] hover:brightness-110 text-white font-semibold py-2 rounded-lg transition" 
                    onclick="createUser()">
                        Create User
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

function createUser() {
    let username = $('#addUsername').val();
    let password = $('#addPassword').val();
    let firstName = $('#addFirstName').val();
    let lastName = $('#addLastName').val();
    let email = $('#addEmail').val();
    let phone = $('#addPhone').val();
    let address = $('#addAddress').val();
    let gender = $('#addGender').val();
    let role = $('#addRole').val();
    let profilePicture =  $('#addProfilePicture')[0].files[0];

    if(!username || !password || !firstName || !lastName || !email || !phone || !address || !gender || !role || !profilePicture) {
        alert('Please fill in all required fields');
        return;
    }
    
    // Use FormData for file uploads
    let formData = new FormData();
    formData.append('action', 'create');
    formData.append('username', username);
    formData.append('password', password);
    formData.append('firstName', firstName);
    formData.append('lastName', lastName);
    formData.append('email', email);
    formData.append('phone', phone);
    formData.append('address', address);
    formData.append('gender', gender);
    formData.append('role', role);
    formData.append('profile_picture', profilePicture);
    
    $.ajax({
        url: '../php/addUser.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if(response.status === 'success') {
                alert('User created successfully');
                location.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(error) {
            console.error('AJAX Error:', error);
            alert('Error creating user');
        }
    });
}
