<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?=CSS_URL."main.css"?>>
    <link rel="stylesheet" href=<?=CSS_URL."user-registration.css"?>>
    <title>Employee Registration Form</title>
</head>

<body>
    <form id="register-back-form" class="register-back-form" action=<?=BASE_URL."/employee"?> method="POST"></form>
    <form id="registration-form" class="registration-form" action="<?=BASE_URL."/employee/create"?>" method="post">
        <p class="form-name-text">
            USER REGISTRATION
        </p>
        
        <h5 class="form-info-text">
            Hover over input bar to see specific instructions (if any)
        </h5>
        <label for="email">Email</label>
        <input type="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" name="password" required>

        <label for="confirm-password">Confirm Password</label>
        <input type="password" name="confirm-password" required>

        <label for="role">Role</label>
        <select name="role" required>
            <option value="1">Cashier</option>
            <option value="0">Manager</option>
        </select>

        <label for="employee-id">Employee ID</label>
        <input type="text" name="employee-id" required>

        <button type="submit" form="registration-form">Submit</button>
        <button type="submit" class="registration-add-back-button" form="registration-back-form">Back To List</button>
    </form>
 
</body>
</html>
