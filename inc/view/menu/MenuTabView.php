<?php
    include __DIR__."/../NavbarView.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?=CSS_URL."main.css"?>>
    <link rel="stylesheet" href=<?=CSS_URL."search-bar.css"?>>
    <link rel="stylesheet" href=<?=CSS_URL."menu-tab.css"?>>
    <link rel="stylesheet" href=<?=CSS_URL."modal.css"?>>
    <title>MenuTabView</title>
</head>

<body>
    <!-- SEARCH BAR -->
    <div class="search-bar-container">
        <form class="search-form" action=<?=BASE_URL."/menuitem/searchByName/menu=MenuTab"?> method="POST">
            <input name="search-query" class="search-bar" type="text" placeholder="Search Item by Name">
            <button class="search-button"><img title="Search" class="search-icon" src="<?= RESOURCE_URL."search.png"?>" alt="Search Button"></button>
        </form>

        <form action=<?=BASE_URL."/menuitem"?> method="POST"> 
            <button class="clear-search" type="submit">Clear Search</button>
        </form>
        
        <form action="<?=BASE_URL."/MenuItem/view/menu=MenuItemAdd"?>" method="POST">        
            <button class="search-bar-add-button"><img title="Add Item" class="add-icon" src="<?= RESOURCE_URL."add.png"?>" alt="Add button"></button>
        </form>
    </div>
    <!-- SEARCH BAR -->

    <!-- GRAPH BUTTONS -->
    <div class="graph-div">
        <p class="graph-text">Graphs:</p>

        <div class="button-container" method="POST">
            <form action="<?=BASE_URL."/menuitem/showMostSoldItems"?>" method="POST">
                <button class="graph-button">Most Sold</button>
            </form>
          
            <form action="<?=BASE_URL."/menuitem/showMostProfitableItems"?>" method="POST">
                <button class="graph-button">Most Profitable</button>
            </form>
           
            <form action="<?=BASE_URL."/menuitem/showMostSoldWithinPeriodLine"?>" method="POST">
                <button class="graph-button right-most">
                    Items Sold <img class="info-icon" src="<?= RESOURCE_URL."info_icon.png"?>" alt="Info icon" title="Select the start and end dates then select this option to show items sold over the specified period.">
                </button>

                <label for="start-date">Start</label>
                <input type="date" name="start-date">

                <label for="end-date">End</label>
                <input type="date" name="end-date">

            </form>
        </div>
    </div>
    <!-- GRAPH BUTTONS -->

    <!-- SELECT * QUERY -->
    <?php if(!empty($data[0])) : ?>
    <?php foreach ($data as $item): ?>
        <div class="menu-item-container">
            <div class="image-and-tags">
                <img class="menu-item-img" src="<?= RESOURCE_URL . $item['image']; ?>" alt="<?=$item['name']; ?>">
                <div class="tag-buttons">
                    <?php $tags = explode(',', $item['tags']); ?>
                    <?php foreach ($tags as $tag): ?>
                        <button class="tag-button"><?=$tag; ?></button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="menu-item-details">
                <p class="item-name"><?=$item['name']; ?></p>
                <p class="item-description"><?=$item['description']; ?></p>
                <p class="item-price">Price: $<?=$item['price']; ?></p>
            </div>

            <div class="action-buttons">
                <form>
                    <button type="button" class="action-button expand-button" data-id="<?=$item['id']; ?>">
                        <img class="action-button-image" src="<?= RESOURCE_URL."expand-icon.png"?>" alt="Expand" title="Expand">
                    </button>
                </form>
                <form>
                    <button type="button" class="action-button edit-button" data-id="<?=$item['id']; ?>">
                        <img class="action-button-image" src="<?= RESOURCE_URL."edit-icon.png"?>" alt="Edit" title="Edit">
                    </button>
                </form>
                
                <form action="<?=BASE_URL."/MenuItem/delete/".$item['id']?>" method="post">
                    <button class="action-button-right-most"><img class="action-button-image" src="<?= RESOURCE_URL."delete-icon.png"?>" alt="Delete" title="Delete"></button>
                </form>
            </div>
        </div>

        <!-- Expand Modal -->
        <div class="modal" id="modal-<?=$item['id']; ?>">
            <div class="modal-content">
                <div class="image-and-tags-modal-div">
                    <img class="modal-menu-item-img" src="<?=RESOURCE_URL.$item['image'];?>" alt="<?=$item['name']; ?>">
                    <div class="modal-tag-buttons">
                        <?php $tags = explode(',', $item['tags']); ?>
                        <?php foreach ($tags as $tag): ?>
                            <button class="modal-tag-button"><?=$tag; ?></button>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="menu-item-details-modal-div">
                    <p class="modal-item-name"><?=$item['name']; ?></p>
                    <p class="modal-item-description"><?=$item['description']; ?></p>
                    <ul class="item-ingredients">
                        <p class="modal-item-ingredients">Ingredients</p>
                        <?php $ingredients = explode(',', $item['ingredients']); ?>
                        <?php foreach ($ingredients as $ingredient): ?>
                            <li><?=$ingredient; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>


        <!-- Edit Modal -->
        <div class="modal edit-modal" id="edit-modal-<?=$item['id']; ?>">
            <div class="modal-content">

                <form action=<?= BASE_URL."/MenuItem/update/".$item['id']?> method="post">
                    <label for="edit-item-name">Name</label>
                    <input type="text" id="edit-item-name" name="name" value="<?=$item['name']; ?>" required>

                    <label for="edit-item-description">Description</label>
                    <input type="text" id="edit-item-description" name="description" value="<?=$item['description']; ?>" required>

                    <label for="edit-item-ingredients">Ingredients</label>
                    <input type="text" id="edit-item-ingredients" name="ingredients" value="<?=str_replace(' ', '',$item['ingredients'])?>" required>

                    <label for="edit-item-cost-to-produce">Cost to produce</label>
                    <input type="text" id="edit-item-cost-to-produce" name="cost-to-produce" value="<?=$item['cost_to_produce']; ?>" required>

                    <label for="edit-item-price">Price</label>
                    <input type="text" id="edit-item-price" name="price" value="<?=$item['price']; ?>" required>

                    <label for="edit-item-stock">Stock</label>
                    <input type="text" id="edit-item-stock" name="stock" value="<?=$item['stock_count']; ?>" required>

                    <label for="edit-item-image">Image</label>
                    <input type="text" id="edit-item-image" name="image" value="<?=$item['image']; ?>" required>

                    <label for="edit-item-discount">Discount</label>
                    <input type="text" id="edit-item-discount" name="discount" value="<?=$item['discount']; ?>" required>

                    <label for="edit-item-discount">Tags</label>
                    <input type="text" id="edit-item-tags" name="tags" value="<?=str_replace(' ', '',$item['tags']);?>" required>
                    <button type="submit">Save Changes</button>
                    
                </form>
            </div>
        </div>
    <?php endforeach; ?>
    <?php endif; ?>

    <script>
        var modals = document.querySelectorAll('.modal');
        var editModals = document.querySelectorAll('.edit-modal');
        var expandButtons = document.querySelectorAll('.expand-button');
        var editButtons = document.querySelectorAll('.edit-button');

        // Function to display a modal by ID
        function displayModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = 'block';
        }

        // Loop through each modal and add click event listeners to the expand buttons
        expandButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var modalId = 'modal-' + this.getAttribute('data-id');
                displayModal(modalId);
            });
        });

        // Loop through each edit button and add click event listeners to open the edit modal
        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var editModalId = 'edit-modal-' + this.getAttribute('data-id');
                displayModal(editModalId);
            });
        });

        // Close the modal if the user clicks outside of it
        window.addEventListener('click', function (event) {
            modals.forEach(function (modal) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });

            editModals.forEach(function (modal) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
