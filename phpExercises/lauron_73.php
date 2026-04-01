<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .nav-buttons {
            text-align: center;
            margin: 20px 0;
        }
        button, input[type="submit"] {
            padding: 10px 20px;
            margin: 5px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        button:hover, input[type="submit"]:hover {
            background-color: #45a049;
        }
        .form-group {
            margin: 15px 0;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], input[type="email"], input[type="number"], textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        input:focus, textarea:focus {
            outline: none;
            border-color: #4CAF50;
            background-color: #f9f9f9;
        }
        .error {
            color: #d32f2f;
            background-color: #ffebee;
            padding: 12px;
            border-radius: 4px;
            margin: 10px 0;
            border-left: 4px solid #d32f2f;
        }
        .success {
            color: #388e3c;
            background-color: #e8f5e9;
            padding: 12px;
            border-radius: 4px;
            margin: 10px 0;
            border-left: 4px solid #388e3c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .action-btn {
            padding: 6px 12px;
            margin: 2px;
            font-size: 12px;
        }
        .delete-btn {
            background-color: #d32f2f;
        }
        .delete-btn:hover {
            background-color: #b71c1c;
        }
        .edit-btn {
            background-color: #1976d2;
        }
        .edit-btn:hover {
            background-color: #1565c0;
        }
        .hidden {
            display: none;
        }
        .section {
            margin-top: 30px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <h1>Address Book</h1>
    
    <div class="nav-buttons">
        <button onclick="showSection('view')">View Members</button>
        <button onclick="showSection('add')">Create New Member</button>
        <button onclick="showSection('search')">Search Member</button>
    </div>

    <?php
        session_start();

        // Initialize address book array in session
        if (!isset($_SESSION['addressBook'])) {
            $_SESSION['addressBook'] = [
                [
                    'id' => 1,
                    'firstName' => 'Juan',
                    'lastName' => 'Dela Cruz',
                    'phone' => '09171234567',
                    'email' => 'juan@email.com',
                    'street' => '123 Main Street',
                    'barangay' => 'Barangay 1',
                    'city' => 'Manila',
                    'province' => 'NCR'
                ],
                [
                    'id' => 2,
                    'firstName' => 'Maria',
                    'lastName' => 'Garcia',
                    'phone' => '09189876543',
                    'email' => 'maria@email.com',
                    'street' => '456 Oak Avenue',
                    'barangay' => 'Barangay 2',
                    'city' => 'Quezon City',
                    'province' => 'NCR'
                ]
            ];
        }

        $addressBook = &$_SESSION['addressBook'];
        $nextId = max(array_column($addressBook, 'id')) + 1;
        $message = '';
        $messageType = '';

        // Handle Add Member
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
            $firstName = trim($_POST['firstName'] ?? '');
            $lastName = trim($_POST['lastName'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $street = trim($_POST['street'] ?? '');
            $barangay = trim($_POST['barangay'] ?? '');
            $city = trim($_POST['city'] ?? '');
            $province = trim($_POST['province'] ?? '');

            if (empty($firstName) || empty($lastName) || empty($phone) || empty($city)) {
                $message = 'Please fill in all required fields.';
                $messageType = 'error';
            } else {
                $newMember = [
                    'id' => $nextId++,
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'phone' => $phone,
                    'email' => $email,
                    'street' => $street,
                    'barangay' => $barangay,
                    'city' => $city,
                    'province' => $province
                ];
                $addressBook[] = $newMember;
                $_SESSION['addressBook'] = $addressBook;
                $message = htmlspecialchars($firstName . ' ' . $lastName) . ' has been added successfully!';
                $messageType = 'success';
            }
        }

        // Handle Delete Member
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
            $memberId = intval($_POST['memberId'] ?? 0);
            $key = array_search($memberId, array_column($addressBook, 'id'));
            
            if ($key !== false) {
                $deletedName = $addressBook[$key]['firstName'] . ' ' . $addressBook[$key]['lastName'];
                array_splice($addressBook, $key, 1);
                $_SESSION['addressBook'] = $addressBook;
                $message = htmlspecialchars($deletedName) . ' has been deleted successfully!';
                $messageType = 'success';
            } else {
                $message = 'Member not found.';
                $messageType = 'error';
            }
        }

        // Handle Edit Member
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
            $memberId = intval($_POST['memberId'] ?? 0);
            $key = array_search($memberId, array_column($addressBook, 'id'));
            
            if ($key !== false) {
                $firstName = trim($_POST['firstName'] ?? '');
                $lastName = trim($_POST['lastName'] ?? '');
                $phone = trim($_POST['phone'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $street = trim($_POST['street'] ?? '');
                $barangay = trim($_POST['barangay'] ?? '');
                $city = trim($_POST['city'] ?? '');
                $province = trim($_POST['province'] ?? '');

                if (empty($firstName) || empty($lastName) || empty($phone) || empty($city)) {
                    $message = 'Please fill in all required fields.';
                    $messageType = 'error';
                } else {
                    $addressBook[$key] = [
                        'id' => $memberId,
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'phone' => $phone,
                        'email' => $email,
                        'street' => $street,
                        'barangay' => $barangay,
                        'city' => $city,
                        'province' => $province
                    ];
                    $_SESSION['addressBook'] = $addressBook;
                    $message = htmlspecialchars($firstName . ' ' . $lastName) . ' has been updated successfully!';
                    $messageType = 'success';
                }
            }
        }

        // Handle Search
        $searchResults = [];
        $searchQuery = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'search') {
            $searchQuery = trim($_POST['searchQuery'] ?? '');
            $searchType = $_POST['searchType'] ?? 'all';

            if (empty($searchQuery)) {
                $message = 'Please enter a search query.';
                $messageType = 'error';
            } else {
                $searchQuery_lower = strtolower($searchQuery);
                
                foreach ($addressBook as $member) {
                    $match = false;
                    
                    if ($searchType == 'name' || $searchType == 'all') {
                        if (stripos($member['firstName'], $searchQuery) !== false || 
                            stripos($member['lastName'], $searchQuery) !== false) {
                            $match = true;
                        }
                    }
                    
                    if ($searchType == 'phone' || $searchType == 'all') {
                        if (stripos($member['phone'], $searchQuery) !== false) {
                            $match = true;
                        }
                    }
                    
                    if ($searchType == 'address' || $searchType == 'all') {
                        if (stripos($member['street'], $searchQuery) !== false || 
                            stripos($member['barangay'], $searchQuery) !== false ||
                            stripos($member['city'], $searchQuery) !== false ||
                            stripos($member['province'], $searchQuery) !== false) {
                            $match = true;
                        }
                    }
                    
                    if ($match) {
                        $searchResults[] = $member;
                    }
                }

                if (empty($searchResults)) {
                    $message = 'No members found matching your search.';
                    $messageType = 'error';
                }
            }
        }

        // Display message
        if (!empty($message)) {
            echo "<div class='container'>";
            echo "<div class='" . $messageType . "'>" . $message . "</div>";
            echo "</div>";
        }
    ?>

    <!-- View Members Section -->
    <div id="view" class="container section">
        <h2>All Members</h2>
        <?php if (!empty($addressBook)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($addressBook as $member): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($member['id']); ?></td>
                            <td><?php echo htmlspecialchars($member['firstName'] . ' ' . $member['lastName']); ?></td>
                            <td><?php echo htmlspecialchars($member['phone']); ?></td>
                            <td><?php echo htmlspecialchars($member['email']); ?></td>
                            <td><?php echo htmlspecialchars($member['city']); ?></td>
                            <td>
                                <button class="action-btn edit-btn" onclick="editMember(<?php echo $member['id']; ?>)">Edit</button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this member?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="memberId" value="<?php echo $member['id']; ?>">
                                    <input type="submit" class="action-btn delete-btn" value="Delete">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; color: #999;">No members in the address book yet.</p>
        <?php endif; ?>
    </div>

    <!-- Add Member Section -->
    <div id="add" class="container section hidden">
        <h2>Add New Member</h2>
        <form method="POST">
            <input type="hidden" name="action" value="add">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="firstName">First Name *</label>
                    <input type="text" name="firstName" id="firstName" placeholder="Enter first name" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name *</label>
                    <input type="text" name="lastName" id="lastName" placeholder="Enter last name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Phone Number *</label>
                    <input type="text" name="phone" id="phone" placeholder="e.g., 09171234567" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="Enter email address">
                </div>
            </div>

            <div class="form-group">
                <label for="street">Street Address</label>
                <input type="text" name="street" id="street" placeholder="Enter street address">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="barangay">Barangay</label>
                    <input type="text" name="barangay" id="barangay" placeholder="Enter barangay">
                </div>
                <div class="form-group">
                    <label for="city">City *</label>
                    <input type="text" name="city" id="city" placeholder="Enter city" required>
                </div>
            </div>

            <div class="form-group">
                <label for="province">Province</label>
                <input type="text" name="province" id="province" placeholder="Enter province">
            </div>

            <input type="submit" value="Add Member">
        </form>
    </div>

    <!-- Search Section -->
    <div id="search" class="container section hidden">
        <h2>Search Members</h2>
        <form method="POST">
            <input type="hidden" name="action" value="search">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="searchQuery">Search Query *</label>
                    <input type="text" name="searchQuery" id="searchQuery" placeholder="Enter search term" required>
                </div>
                <div class="form-group">
                    <label for="searchType">Search By</label>
                    <select name="searchType" id="searchType" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="all">All Fields</option>
                        <option value="name">Name (First or Last)</option>
                        <option value="phone">Phone Number</option>
                        <option value="address">Address (City, Barangay, etc)</option>
                    </select>
                </div>
            </div>

            <input type="submit" value="Search">
        </form>

        <?php if (!empty($searchResults)): ?>
            <h3 style="margin-top: 20px; color: #388e3c;">Search Results (<?php echo count($searchResults); ?> found)</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($searchResults as $member): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($member['id']); ?></td>
                            <td><?php echo htmlspecialchars($member['firstName'] . ' ' . $member['lastName']); ?></td>
                            <td><?php echo htmlspecialchars($member['phone']); ?></td>
                            <td><?php echo htmlspecialchars($member['email']); ?></td>
                            <td><?php echo htmlspecialchars($member['street'] . ', ' . $member['barangay'] . ', ' . $member['city']); ?></td>
                            <td>
                                <button class="action-btn edit-btn" onclick="editMember(<?php echo $member['id']; ?>)">Edit</button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this member?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="memberId" value="<?php echo $member['id']; ?>">
                                    <input type="submit" class="action-btn delete-btn" value="Delete">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Edit Modal (Hidden by default) -->
    <div id="editModal" class="container section hidden" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 90%; max-width: 500px; z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.2); max-height: 90vh; overflow-y: auto;">
        <h2>Edit Member</h2>
        <form method="POST" id="editForm">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="memberId" id="editMemberId">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="editFirstName">First Name *</label>
                    <input type="text" name="firstName" id="editFirstName" required>
                </div>
                <div class="form-group">
                    <label for="editLastName">Last Name *</label>
                    <input type="text" name="lastName" id="editLastName" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="editPhone">Phone Number *</label>
                    <input type="text" name="phone" id="editPhone" required>
                </div>
                <div class="form-group">
                    <label for="editEmail">Email Address</label>
                    <input type="email" name="email" id="editEmail">
                </div>
            </div>

            <div class="form-group">
                <label for="editStreet">Street Address</label>
                <input type="text" name="street" id="editStreet">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="editBarangay">Barangay</label>
                    <input type="text" name="barangay" id="editBarangay">
                </div>
                <div class="form-group">
                    <label for="editCity">City *</label>
                    <input type="text" name="city" id="editCity" required>
                </div>
            </div>

            <div class="form-group">
                <label for="editProvince">Province</label>
                <input type="text" name="province" id="editProvince">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <input type="submit" value="Save Changes">
                <button type="button" onclick="closeEditModal()" style="background-color: #999;">Cancel</button>
            </div>
        </form>
    </div>

    <!-- Overlay for modal -->
    <div id="modalOverlay" class="hidden" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 999;" onclick="closeEditModal()"></div>

    <script>
        function showSection(section) {
            document.getElementById('view').classList.add('hidden');
            document.getElementById('add').classList.add('hidden');
            document.getElementById('search').classList.add('hidden');
            
            document.getElementById(section).classList.remove('hidden');
        }

        function editMember(memberId) {
            // Get member data from the current page (PHP)
            const memberData = <?php echo json_encode($addressBook); ?>;
            const member = memberData.find(m => m.id === memberId);
            
            if (member) {
                document.getElementById('editMemberId').value = member.id;
                document.getElementById('editFirstName').value = member.firstName;
                document.getElementById('editLastName').value = member.lastName;
                document.getElementById('editPhone').value = member.phone;
                document.getElementById('editEmail').value = member.email;
                document.getElementById('editStreet').value = member.street;
                document.getElementById('editBarangay').value = member.barangay;
                document.getElementById('editCity').value = member.city;
                document.getElementById('editProvince').value = member.province;
                
                document.getElementById('editModal').classList.remove('hidden');
                document.getElementById('modalOverlay').classList.remove('hidden');
            }
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('modalOverlay').classList.add('hidden');
        }
    </script>
</body>
</html>