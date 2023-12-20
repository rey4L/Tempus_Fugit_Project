
# Quick Setup Guide

1. **Extract** the `Tempus_Fugit_Project` folder into the `htdocs` directory or use `git clone` to clone the repository from <https://github.com/rey4L/Tempus_Fugit_Project.git> into `htdocs`.
2. **Start** php and MySQL in XAMMP.
3. **Create** a database named `karens_kitchen` in PhpMyAdmin. _If database `karens_kitchen` already exists, please drop all tables to facilitate the database initialization._
4. **Navigate** to the `/Tempus_Fugit_Project` directory.

## User Accounts

To access the system, you must first register for a user account. There are serveral rules that should be aware of:

1. To register, you must be in possession of a valid employee id. For simplicity, these initialized employees possess ids 1, 2, and 3.
2. There exist a one to one relation between an employee and a user account. Therefore, only one account can be created for an employee.
3. The given job roles for an employee will dictate whether or not they qualify for a job role, that is either a manager or cashier. Employees with id of 1 and 2 qualify for a manager/cashier role and employee 3 qualifies only for a cashier role.
4. The same email cannot be used for multiple accounts
5. Passwords must be strong

## Graphs

All graphs are located on the menu tab. These graphs will only show data until items have been sold. Therefore, inorder to see the graphs, first use the register to create bills.

In particular note to the graph whose identifier button is `Items sold`, while it is not a rule, do select the same start and end date. The graph will render but since it is only one data point, only a single point will be plotted. This is representative of what the graph is, that is a line graph. 

## Known / Notable Bug Fixes Or Improvements

- Menu item's image url field when adding a new menu item is now functional.
- Data stored on register, prior to hitting the confirm button, is now non-volatile, such that closing the browser or deleting the session will not clear the values and result in a additional empty bill created that will never be used.
- Unecessary number values such as `INT(20)` on database have been removed
- Database.php init no longer depends on a session for preventing duplicate inputs. `IGNORE` sql statement is used instead. However a cookie is now utilized. See [[README#Database Initialization]].
- config.json has been created to easily manage `GET` and `POST` permissions as well as user role privilages.
- All additional given requirements have been satisified.

## Database Initialization

The project automatically initializes the database with data on the first run. To reinitialize the database, if needed, follow these steps:

1. **Drop** existing tables in the `karens_kitchen` database.
2. **Delete** the existing cookie `init`:
   - Open browser's inspect tool.
   - Navigate to the Application Tab.
   - Locate and delete the session cookie under `init`

Note that the application only initializes menuitems and employees. To see bill on bill tab, please create one or more using the cash register interface.

Also to note, with the set database values for menuitem, bill item and bill, the max price and total is 999999999999999999999999.99999. Therefore, in the unlikely event a number higher than this is calculated or added as the price for an item, it will appear as a math error in calculation. However, it is not so. The values in the database are simply limited to their given size.



## Configuration Settings

To run the project in a subdirectory within `htdocs`, adjust the global variables `BASE_URL`, `RESOURCE_PATH`, and `CSS_PATH` in `inc/core/config.php`.

For instance, to run the application from a subfolder named `personal` (located within `htdocs` and containing the `Tempus_Fugit_Project` project folder), modify the global variables as follows:

#### Example Folder Structure:

    htdocs
    ├── personal
        └── Tempus_Fugit_Project

1. `BASE_URL = "/personal/Tempus_Fugit_Project";`
2. `CSS_PATH = "http://localhost/personal/Tempus_Fugit_Project/public/css/"`
3. `RESOURCE_URL = "http://localhost/personal/Tempus_Fugit_Project/public/images/"`

Note that `inc/core/config.php` is where the configurations for the database are set. If desirable, go here to change database settings.



## CSS Loading Issues

If the webpage styling isn't appearing, perform these steps:

1. Go to your browser's settings.
2. Search for and select the option to clear browsing history.
3. Specifically, choose to clear _Cache images and files_ (instructions based on Chrome Web Browser).
4. Reload the webpage.

_For a visual reference of the intended website design, please refer to the Figma file:_ <https://www.figma.com/file/CpIRBICRaH4dku8PVfwDsJ/CSE3101_Design_Assigment_2?type=design&node-id=0%3A1&mode=design&t=FQXvdimrpZpFMqSp-1>.

_N.B_ The design is not accurate to the final outcome. It is similar enough to give an idea of what the website should look like.

## Inserting Multiple Values

When you need to insert multiple values into fields like _othernames_ for employees or _tags_ and _ingredients_ for menu items, enter the values separated by commas without spaces, like "tag1,tag2,tag3". Such fields are assisted by a info bubble icon such that when hovered over, will provide instructions.

Info bubbles in general will provide instructions for the user.

## Understanding Action Buttons

For clarity on the function of each action button, simply hover your cursor over them. A brief description will appear, usually within half a second, to guide you on their specific purpose.


