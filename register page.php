<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4Ps Member Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="register page.css" />
</head>

<body>
    <div class="header-mother-div">
        <div class="header-div2">
            <h1 style="background: linear-gradient(to right, blue, red); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                PANTAWID PAMILYANG PILIPINO PROGRAM
            </h1>

        </div>
    </div>

    <div class="reg-div">
        <h2>4Ps Member Registration</h2>
        <?php

        if (isset($_SESSION['error'])) {
            echo '<p class="error-message">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<p style="color:green; text-align:center;">' . $_SESSION['success'] . '</p>';
            unset($_SESSION['success']);
        }
        ?>

        <form id="addMemberForm" class="add-member-form" action="connectdbs.php" method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="username">Member Name:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="mobile">Mobile Number:</label>
            <input type="tel" id="mobile" name="mobile" pattern="[0-9]{11}" required>

            <label for="id-number">ID Number:</label>
            <input type="text" id="id-number" name="id_number" required>

            <label for="address">Address:</label>
            <select id="address" name="address" required>
                <option value="" disabled selected>Select your address</option>
                <option value="purok 1">brgy parian purok 1</option>
                <option value="purok 2">brgy parian purok 2</option>
                <option value="purok 3">brgy parian purok 3</option>
                <option value="purok 4">brgy parian purok 4</option>
                <option value="purok 5">brgy parian purok 5</option>
                <option value="purok 6">brgy parian purok 6</option>
                <option value="purok 7">brgy parian purok 7</option>
                <option value="purok Siete Media">brgy parian Siete Media</option>
            </select>

            <label for="family-size">Family Size:</label>
            <input type="number" id="family-size" name="family_size" min="1" max="25" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>

            <label for="password">Password:</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <i id="togglePassword" class="fa-solid fa-eye toggle-password"></i>
            </div>

            <label for="confirmPassword">Confirm Password:</label>
            <div class="password-container">
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <i id="toggleConfirmPassword" class="fa-solid fa-eye toggle-password"></i>
            </div>
            <span id="passwordMessage" class="error-message"></span>

            <div class="buttons">
                <button type="reset">Reset</button>
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>

    <script>
        const toggleVisibility = (toggleElement, targetField) => {
            if (targetField.type === 'password') {
                targetField.type = 'text';
                toggleElement.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                targetField.type = 'password';
                toggleElement.classList.replace('fa-eye-slash', 'fa-eye');
            }
        };

        document.getElementById('togglePassword').addEventListener('click', () => {
            toggleVisibility(
                document.getElementById('togglePassword'),
                document.getElementById('password')
            );
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', () => {
            toggleVisibility(
                document.getElementById('toggleConfirmPassword'),
                document.getElementById('confirmPassword')
            );
        });

        document.getElementById('mobile').addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 11);
        });

        document.getElementById('id-number').addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 12);
        });

        document.getElementById('family-size').addEventListener('input', function() {
            const value = parseInt(this.value.replace(/\D/g, ''), 10);
            this.value = value > 0 && value <= 25 ? value : '';
        });

        document.getElementById('addMemberForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                document.getElementById('passwordMessage').textContent = 'Passwords do not match. Please try again.';
                return false;
            }
        });
    </script>
</body>

</html>