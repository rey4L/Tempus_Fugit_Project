<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?=CSS_URL."main.css"?>>
    <link rel="stylesheet" href=<?=CSS_URL."navbar.css"?>>
    <title>Navigation Bar</title>
</head>

<body>
    <div class="navigation-bar">
        <div class="profile-info-container">
            <img class="profile-picture" src="<?=RESOURCE_URL. "office_guy.png"?>" alt="">
            <div class="profile-details">
                <p class="profile-username">USERNAME HERE</p>
                <form action="<?=BASE_URL?>">
                    <button type="submit">Log Out</button>
                </form>
            </div>
        </div>
        
        <a class="nav-button" href="<?= BASE_URL."/Register"?>">Register</a> 
        <a class="nav-button" href="<?= BASE_URL."/MenuItem" ?>">Menu</a>
        <a class="nav-button" href="<?= BASE_URL."/Employee" ?>">Employees</a> 
        <a class="nav-button" href="<?= BASE_URL."/Bill" ?>">Bills</a>
    </div>
</body>
</html>
