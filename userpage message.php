
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="userpage message.css">
    <link rel="stylesheet" href="your-external-styles.css"> <!-- Add your external CSS file here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>User Page Message</title>
    <style>
        /* Your existing styles */
    </style>
</head>

<body>
    <div class="header-mother-div">
        <div class="header-div1">
            <div class="user-div">
                <!-- The user icon will be updated here -->
                <img id="headerProfileIcon" src="default-user-icon.png" alt="User Icon" 
                style="width:50px; height:50px; border-radius:50%; object-fit:cover;margin-left: -20px;margin-top: -19px;">
            </div>
        </div>

        <div class="header-div2">
            <h1>PANTAWID PAMILYANG PILIPINO PROGRAM</h1>
            <div class="logo-pic">
                <img class="pic" src="4ps-logo.png" alt="">  
            </div>
        </div>
    </div>

    <br><br><br>

    <div class="icon-div">
        <div class="icon">
            <a href="userpagehome.html"><button class=""><i class="fa-solid fa-house"></i> Home </button></a>
        </div>

        <div class="icon">
            <a href="usersidemeeting.html"><button class="meeting-button" id="meeting-button"><i class="fa-solid fa-users-line"></i> Meeting </button></a>
        </div>

        <div class="icon">
            <a href="usersideupdates.html"><button class="update-button" id="update-button"><i class="fa-solid fa-volume-high"></i> Updates </button></a>
        </div>

        <div class="icon">
            <a href="#"><button class="message-button" id="message-button"><i class="fa-solid fa-comment"></i> Message </button></a>
        </div>

        <div class="icon">
            <a href="user-com-eng.html"><button class="news-button"><i class="fa-solid fa-newspaper"></i> News </button></a>
        </div>

        <div class="icon">
            <a href="profile.html"><button><i class="fa-solid fa-user"></i> Profile </button></a>
        </div>
    </div>

    <br><br>

    <!-- Message Dashboard Section -->
    <div class="message-dashboard">
        <h2>Message Dashboard</h2>
        <div class="message-box" id="message-box">
            <!-- Existing messages will be displayed here -->
        </div>

        <div class="message-input">
            <textarea id="user-message" placeholder="Type your message here..."></textarea>
            <button class="send-button" id="user-send-button"><i class="fa-solid fa-paper-plane"></i> Send</button>
        </div>
    </div>

    <script>
        // Load profile picture from localStorage
        function loadProfilePicture() {
            const member = JSON.parse(localStorage.getItem('member')) || {};
            const profileIcon = document.getElementById('headerProfileIcon');
            if (member.picture) {
                profileIcon.src = member.picture; // Update the profile picture
            }
        }

        // Function to get current date and time
        function getCurrentDateTime() {
            let now = new Date();
            return now.toLocaleString();
        }

        // Load messages from localStorage
        function loadMessages() {
            const messages = JSON.parse(localStorage.getItem("messages")) || [];
            const messageBox = document.getElementById("message-box");
            messageBox.innerHTML = ""; // Clear existing messages

            messages.forEach((message, index) => {
                const newMessageDiv = document.createElement("div");
                newMessageDiv.classList.add("message", message.role);
                newMessageDiv.innerHTML = `
                    <p>${message.text}</p>
                    <span class="message-time">${message.role.charAt(0).toUpperCase() + message.role.slice(1)} - ${message.time}</span>
                    ${message.role === "user" ? `<button class="delete-button" onclick="deleteMessage(${index})">Delete</button>` : ''}
                `;
                messageBox.appendChild(newMessageDiv);
            });
        }

        // Function to send user message
        document.getElementById("user-send-button").addEventListener("click", function() {
            const messageText = document.getElementById("user-message").value;
            if (messageText.trim() !== "") {
                const message = {
                    role: "user",
                    text: messageText,
                    time: getCurrentDateTime()
                };

                // Retrieve existing messages and add the new one
                const messages = JSON.parse(localStorage.getItem("messages")) || [];
                messages.push(message);
                localStorage.setItem("messages", JSON.stringify(messages));

                // Clear the textarea and reload messages
                document.getElementById("user-message").value = "";
                loadMessages();
            }
        });

        // Function to delete user message
        function deleteMessage(index) {
            const messages = JSON.parse(localStorage.getItem("messages")) || [];
            
            if (messages[index].role === "user") { // Allow deletion only for user messages
                messages.splice(index, 1); // Remove the message at the specified index
                localStorage.setItem("messages", JSON.stringify(messages));
                loadMessages(); // Reload messages after deletion
            }
        }

        // Load profile picture and messages on page load
        window.onload = function() {
            loadProfilePicture();
            loadMessages();
        };
    </script>
</body>
</html>
