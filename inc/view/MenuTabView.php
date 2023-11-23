<?php
    include "NavBarView.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/menu-tab.css">
    <link rel="stylesheet" href="../../public/css/search-bar.css">
    <title>MenuTabView</title>
</head>
<body>
  <!-- SEARCH BAR -->
  <div class="search-bar-container">
        <input class="search-bar" type="text" placeholder="Search Menu item by name or id">
        <button class="search-button"><img title="Search" class="search-icon" src="../../public/images/search.png" alt="Search Button"></button>
        <select class="search-bar-dropdown-1" name="tags" id="tags">
            <option disabled selected>Tags</option>
            <option value="savory">Savory</option>
            <option value="healthy">Healthy</option>
            <option value="dessert">Dessert</option>
        </select>
        <select class="search-bar-dropdown-2" name="price" id="price">
            <option disabled selected>Price</option>
            <option value="under-1000">Under 1000</option>
            <option value="1000-to-5000">1000 to 5000</option>
            <option value="over-5000">Over 5000</option>
        </select>
        <button class="search-bar-add-button"><img title="Add Item" class="add-icon" src="../../public/images/add.png" alt="Add button"></button>
    </div>
    <!-- SEARCH BAR -->

  <div class="div">
  <div class="div-2">
    <div class="div-3">
      <div class="column">
        <div class="div-4">
          <div class="div-5">
            <div class="div-6">
              <img
                loading="lazy"
                src="../../public/images/icecream.png"
                class="img-2"
              />
            </div>
          </div>
          <div class="div-7">
            <div class="div-8">Desert</div>
            <div class="div-9">Savory</div>
          </div>
        </div>
      </div>
      <div class="column-2">
        <div class="div-10">
          <div class="div-11">
            <div class="div-12">Savory Icecream</div>
            <div class="div-13">
              <img
                loading="lazy"
                src="../../public/images/up-icon.png"
                class="img-3"
              />
              <img
                loading="lazy"
                src="../../public/images/writing-icon.png"
                class="img-4"
              />
              <div class="div-14">
                <img
                  loading="lazy"
                  src=../../public/images/trash-icon.png
                  class="img-5"
                />
              </div>
            </div>
          </div>
          <div class="div-15">
            This is a brief description of the menu item This is a brief
            description of the menu item. This is a brief description of the
            menu item. This is a brief description of the menu item.
          </div>
          <div class="div-16">
            <span
              style="
                font-family: Inter, sans-serif;
                font-weight: 700;
              "
            >
              Price:
            </span>
            <span
              style="
                font-family: Inter, sans-serif;
                font-weight: 400;
              "
            >
              $xxxx
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="div-17">
    <div class="div-18">
      <div class="column-3">
        <div class="div-19">
          <div class="div-20">
            <img
              loading="lazy"
              src="../../public/images/icecream-2.png"
              class="img"
            />
          </div>
        </div>
      </div>
      <div class="column-4">
        <div class="div-21">
          <div class="div-22">
            <div class="div-23">Savory Icecream</div>
            <div class="div-24">
              <img
                loading="lazy"
                srcset="../../public/images/up-icon.png"
                class="img-7"
              />
              <img
                loading="lazy"
                srcset="../../public/images/writing-icon.png"
                class="img-8"
              />
              <div class="div-25">
                <img
                  loading="lazy"
                  srcset="../../public/images/trash-icon.png"
                  class="img-9"
                />
              </div>
            </div>
          </div>
          <div class="div-26">
            This is a brief description of the menu item This is a brief
            description of the menu item. This is a brief description of the
            menu item. This is a brief description of the menu item.
          </div>
          <div class="div-27">
            <span
              style="
                font-family: Inter, sans-serif;
                font-weight: 700;
              "
            >
              Price:
            </span>
            <span
              style="
                font-family: Inter, sans-serif;
                font-weight: 400;
              "
            >
              $xxxx
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="div-28">
    <div class="div-29">Desert</div>
    <div class="div-30">Savory</div>
    <div class="div-31">Vegan</div>
  </div>
</div>
  </body>
</html>
  