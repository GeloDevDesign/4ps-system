<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="admin regform.css">
    <style>
        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

       
    </style>
</head>

<body>

    <div class="admin-container">
        <aside class="sidebar">
            <h2 class="top-textash">4Ps Super Admin</h2>
            <nav class="dash">
                <ul>
                    <li><a href="superadmin.php">Dashboard</a></li>
                    <li><a href="adminsidemm.php">Manage Members</a></li>
                    <li><a href="adminsidemeeting.php">Meeting</a></li>
                    <li><a href="adminsideupdates.php">FDS Updates</a></li>
                    <li><a href="adminside 4psmm dashboard.php">4Ps Members Dashboard</a></li>
                    <li><a href="admin regform.php" class="active">Register New Admin</a></li>
                    <li><a href="index.php">Logout</a></li>
                </ul>
            </nav>
        </aside>
    </div>

    <div class="container mt-5">
        <h4 class="text-center">Register New Admin</h4>
        <form id="adminRegistrationForm" action="adminRegister.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">User Name</label>
                <input type="text" class="form-control" id="name" name="username" placeholder="Enter full name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
            </div>
            <div class="mb-3 password-container">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                <span style="margin-right: 155px;margin-top:10px" class="toggle-password" onclick="togglePasswordVisibility('password')">&#128065;</span >
            </div>
            <div class="mb-3 password-container">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
                <span style="margin-right: 155px;margin-top:10px" class="toggle-password" onclick="togglePasswordVisibility('confirm_password')">&#128065;</span>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role">
                    <option value="admin">Admin</option>
                    <option value="super admin">Super Admin</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Register Admin</button>
        </form>


        <div class="admin-list">
            <h4>Registered Admins</h4>
            <table>
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="adminList">
                    <!-- Admins will be dynamically inserted here -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const adminListElem = document.getElementById('adminList');
        let admins = JSON.parse(localStorage.getItem('admins')) || [];

        function renderAdminList() {
            adminListElem.innerHTML = '';
            admins.forEach((admin, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><img src="${admin.profilePicture}" alt="Profile Picture"></td>
                    <td>${admin.name}</td>
                    <td>${admin.email}</td>
                    <td>${admin.role}</td>
                    <td><span class="delete-btn" onclick="deleteAdmin(${index})">Delete</span></td>
                `;
                adminListElem.appendChild(row);
            });
        }

        function deleteAdmin(index) {
            admins.splice(index, 1);
            localStorage.setItem('admins', JSON.stringify(admins));
            renderAdminList();
        }

        document.getElementById('adminRegistrationForm').addEventListener('submit', function(e) {


            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const role = document.getElementById('role').value;
            const profilePicture = document.getElementById('profilePicture').files[0];

            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                return;
            }

            const reader = new FileReader();
            reader.onload = function() {
                admins.push({
                    name,
                    email,
                    role,
                    profilePicture: reader.result
                });
                localStorage.setItem('admins', JSON.stringify(admins));
                document.getElementById('adminRegistrationForm').reset();
                renderAdminList();
            };
            reader.readAsDataURL(profilePicture);
        });

        document.addEventListener('DOMContentLoaded', renderAdminList);

        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const fieldType = field.type === 'password' ? 'text' : 'password';
            field.type = fieldType;
        }
    </script>

</body>

</html>