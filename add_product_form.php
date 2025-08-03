<?php
require('database.php');

// Fetch all categories for the dropdown menu
$query = 'SELECT *
          FROM categories
          ORDER BY categoryID';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>CodeLatte's Studio Inventory</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <header><h1>Softstack Studios</h1></header>

    <main>
        <a href="#add_product_form" class="skip-link sr-only">Skip to form</a>
        <h1 id="form-heading">Add a New Project</h1>
        <form action="add_product.php" method="post"
              id="add_product_form" aria-labelledby="form-heading">

            <fieldset>
                <legend class="sr-only">New Project Details</legend>
                
                <div>
                    <label for="category_id">Workshop:</label>
                    <select name="category_id" id="category_id">
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo $category['categoryID']; ?>">
                                <?php echo $category['categoryName']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="code">Identifier (Code):</label>
                    <input type="text" id="code" name="code" required>
                </div>

                <div>
                    <label for="name">Project Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div>
                    <label for="price">List Price:</label>
                    <input type="number" id="price" name="price" step="0.01" required>
                </div>

            </fieldset>

            <div class="submit-button">
                <button type="submit">Add Project</button>
            </div>

        </form>
        <p><a href="index.php">View Project List</a></p>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Softstack Studios. All Rights Reserved.</p>
    </footer>
</body>
</html>
