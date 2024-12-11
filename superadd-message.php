<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="superadd-message.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>4Ps Super Admin</h2>
            <nav>
                <ul>
                    <li><a href="superadmin.html">Dashboard</a></li>
                    <li><a href="adminsidemm.html">Manage Members</a></li>
                    <li><a href="adminsidemeeting.html">Meeting</a></li>
                    <li><a href="adminsideupdates.html">Updates</a></li>
                    <li><a href="#" class="active">Message</a></li>
                    <li><a href="adminside 4psmm dashboard.html">4Ps Members Dashboard</a></li>
                    <li><a href="admin_regform.html">Register New Admin</a></li>
                    <li><a href="homepagelogin.html">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main content -->
        <main class="main-content">
            <h1>Message Members</h1>
            
            <!-- Members List -->
            <div class="member-list">
                <h3>Registered Members</h3>
                <ul id="member-list">
                    <!-- Members will be dynamically added here -->
                </ul>
            </div>

            <!-- Message Box for selected member -->
            <div class="message-section" id="message-section" >
                <h3>Messaging <span id="member-name"></span></h3>
                <div id="message-box" class="message-box">
                    <!-- Messages will appear here -->
                </div>
                <textarea id="admin-message" placeholder="Type your message here"></textarea>
                <button id="send-button">Send</button>
            </div>
        </main>
    </div>

    <script>
        // Function to display all registered members from localStorage in the member list
        function loadMembers() {
            const memberList = document.getElementById("member-list");
            memberList.innerHTML = ""; // Clear the list before reloading
    
            // Retrieve registered members from localStorage
            const members = JSON.parse(localStorage.getItem('members')) || [];
            console.log("Loaded members from localStorage:", members);
    
            // Populate the list with each registered member
            members.forEach(member => {
                const memberItem = document.createElement("li");
                memberItem.textContent = member.name; // Display the member's name
                memberItem.classList.add("member-item");
                memberItem.addEventListener("click", () => loadMessagesForMember(member.name));
                memberList.appendChild(memberItem);
            });
        }
    
        // Function to load messages for the selected member
        function loadMessagesForMember(memberName) {
            document.getElementById("member-name").textContent = memberName;
            document.getElementById("message-section").style.display = "block";
            console.log("Loading messages for member:", memberName);
    
            // Load messages specific to the selected member
            loadMessages(memberName);
        }
    
        // Helper function to get current date and time for messages
        function getCurrentDateTime() {
            let now = new Date();
            return now.toLocaleString();
        }
    
        // Function to load messages for a specific member by name from localStorage
        function loadMessages(memberName) {
            const messages = JSON.parse(localStorage.getItem("messages_" + memberName)) || [];
            console.log(`Messages loaded for member ${memberName}:`, messages);
    
            const messageBox = document.getElementById("message-box");
            messageBox.innerHTML = ""; // Clear existing messages
    
            messages.forEach((message, index) => {
                const newMessageDiv = document.createElement("div");
                newMessageDiv.classList.add("message", message.role);
                newMessageDiv.innerHTML = `
                    <p>${message.text}</p>
                    <span class="message-time">${message.role.charAt(0).toUpperCase() + message.role.slice(1)} - ${message.time}</span>
                    ${message.role === "admin" ? `<button class="delete-button" onclick="deleteMessage(${index}, '${memberName}')">Delete</button>` : ''}
                `;
                messageBox.appendChild(newMessageDiv);
            });
        }
    
        // Function to send a message to the selected member
        document.getElementById("send-button").addEventListener("click", function() {
            const messageText = document.getElementById("admin-message").value;
            const memberName = document.getElementById("member-name").textContent;
    
            if (!memberName) {
                console.warn("No member selected for messaging.");
                return;
            }
    
            if (messageText.trim() !== "") {
                const message = {
                    role: "admin",
                    text: messageText,
                    time: getCurrentDateTime()
                };
    
                // Retrieve existing messages for this member and add the new message
                const messages = JSON.parse(localStorage.getItem("messages_" + memberName)) || [];
                messages.push(message);
                localStorage.setItem("messages_" + memberName, JSON.stringify(messages));
                console.log(`New message saved for member ${memberName}:`, message);
    
                // Clear the message input and reload messages
                document.getElementById("admin-message").value = "";
                loadMessages(memberName);
            }
        });
    
        // Function to delete a specific message for the selected member
        function deleteMessage(index, memberName) {
            const messages = JSON.parse(localStorage.getItem("messages_" + memberName)) || [];
    
            if (messages[index].role === "admin") {
                messages.splice(index, 1); // Remove the message at the specified index
                localStorage.setItem("messages_" + memberName, JSON.stringify(messages));
                console.log(`Message deleted at index ${index} for member ${memberName}`);
                loadMessages(memberName); // Reload messages after deletion
            }
        }
    
        // Load members on page load
        window.onload = loadMembers;
    </script>
    
    
    
</body>
</html>
