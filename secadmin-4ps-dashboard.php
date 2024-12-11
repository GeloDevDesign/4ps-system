<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>secAdmin - Add Latest Update</title>
    <link rel="stylesheet" href="adminside 4psmm dashboard.css">
</head>
<body>

    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>4Ps Admin</h2>
            <nav>
                <ul>
                    <li><a href="secadmin.php" class="">Dashboard</a></li>
                   
                    <li><a href="secadmin-meeting.php">Meeting</a></li>
                    <li><a href="secadmin-update.php"> Updates</a></li>
                    <li><a href="" class="active">4Ps Members Dashboard</a></li>
                    <li><a href="index.php">Logout</a></li>
                </ul>
            </nav>
        </aside>









    <div class="container">
        <h1>Add Latest Update</h1>
        <form id="update-form">
            <label for="update-title" class="">Update Title:</label>
            <input type="text" id="update-title" required>

            <label for="update-image">Upload Image:</label>
            <input type="file" id="update-image" accept="image/*" required>

            <button type="submit">Add Update</button>
        </form>
    </div>

    <script>
        // Handle form submission
        document.getElementById('update-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting normally
            
            const title = document.getElementById('update-title').value;
            const imageInput = document.getElementById('update-image');
            const file = imageInput.files[0];

            const reader = new FileReader();
            reader.onloadend = function() {
                const updates = JSON.parse(localStorage.getItem('updates')) || [];
                updates.push({
                    imageUrl: reader.result,
                    title: title
                });
                localStorage.setItem('updates', JSON.stringify(updates));
                alert('Update added successfully!');
                document.getElementById('update-form').reset(); // Reset the form
            }
            if (file) {
                reader.readAsDataURL(file); // Read the image as a data URL
            }
        });
    </script>
</body>
</html>