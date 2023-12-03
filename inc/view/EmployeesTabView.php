<?php
    include "NavbarView.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?=CSS_URL."main.css"?>>
    <link rel="stylesheet" href=<?=CSS_URL."search-bar.css"?>>
    <link rel="stylesheet" href=<?=CSS_URL."table.css"?>>
    <link rel="stylesheet" href=<?=CSS_URL."employee-tab.css"?>>
</head>

<body>
    <!-- SEARCH BAR -->
    <div class="search-bar-container">
        <input class="search-bar" type="text" placeholder="Search Bills by Transaction ID">
        <button class="search-button"><img title="Search" class="search-icon" src="<?= RESOURCE_URL."search.png"?>" alt="Search Button"></button>
        <select class="search-bar-dropdown-1" name="status" id="status">
            <option disabled selected>Status</option>
            <option value="completed">Completed</option>
            <option value="pending">Pending</option>
            <option value="cancelled">Cancelled</option>
        </select>
        <select class="search-bar-dropdown-2" name="date" id="date">
            <option disabled selected>Date</option>
            <option value="last-week">Last Week</option>
            <option value="last-month">Last Month</option>
            <option value="last-six-months">Last 6 Months</option>
        </select>
        <form action="<?=BASE_URL."/MenuItem/view/EmployeeAdd"?>" method="POST">
            <button class="search-bar-add-button"><img title="Add Bill" class="add-icon" src="<?= RESOURCE_URL."add.png"?>" alt="Add button"></button>
        </form>
    </div>
    <!-- SEARCH BAR -->

    <table class="employees-table">
        <thead>
            <tr>
                <th class="column-1">Name</th>
                <th class="column-2">Role</th>
                <th class="column-3">Email</th>
                <th class="column-4">Contact Number</th>
                <th class="column-5">Status</th>
                <th class="column-6">Actions</th>
            </tr>
        </thead>
    
        <tbody>
            <?php foreach ($data as $employee): ?>
                <tr>
                    <td><?= $employee['first_name'] . ' ' . implode(" ", explode(",", trim($employee['other_names'], ","))) . ' ' . $employee['last_name'] ?></td>
                    <td><?= $employee['job_role'] ?></td>
                    <td><?= $employee['email'] ?></td>
                    <td><?= $employee['contact_number'] ?></td>
                    <td><?= ucfirst($employee['status']) ?></td>
                    <td>
                        <form action=<?=BASE_URL."/employee/findOne/".$employee['id']?> method="POST">
                            <button type="submit"><img src="<?= RESOURCE_URL."expand-icon.png"?>" alt="Expand Icon" title="View"></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
  
</body>