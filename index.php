<?php
require_once('database.php');

// Get category ID
if (!isset($category_id)) {
    $category_id = filter_input(INPUT_GET, 'category_id',
        FILTER_VALIDATE_INT);
    if ($category_id == NULL || $category_id == FALSE) {
        $category_id = 1;
    }
}
// Get name for selected category
$queryCategory = 'SELECT * FROM categories
                  WHERE categoryID = :category_id';
$statement1 = $db->prepare($queryCategory);
$statement1->bindValue(':category_id', $category_id);
$statement1->execute();
$category = $statement1->fetch();
$category_name = $category['categoryName'];
$statement1->closeCursor();


// Get all categories
$query = 'SELECT * FROM categories
          ORDER BY categoryID';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();

// Get products for selected category
$queryProducts = 'SELECT * FROM products
                  WHERE categoryID = :category_id
                  ORDER BY productID';
$statement3 = $db->prepare($queryProducts);
$statement3->bindValue(':category_id', $category_id);
$statement3->execute();
$products = $statement3->fetchAll();
$statement3->closeCursor();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>CodeLatte's Studio Inventory</title>
    <link rel="stylesheet" href="main.css" />
</head>

<body>
<a href="#main-content" class="skip-link">Skip to main content</a>
<header><h1>Softstack Studios</h1></header>
<main id="main-content">
    <h1>Project List</h1>

    <aside>
        <h2>Workshops</h2>
        <nav aria-label="Workshop list navigation">
        <ul>
            <?php foreach ($categories as $category) :
                $is_current = ($category['categoryID'] == $category_id) ? 'aria-current="page"' : ''; ?>
            <li><a href=".?category_id=<?php echo $category['categoryID']; ?>" <?php echo $is_current; ?>>
                    <?php echo $category['categoryName']; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        </nav>
    </aside>

    <section aria-labelledby="section-heading">
        <h2 id="section-heading"><?php echo $category_name; ?></h2>
        <table>
            <caption>Project List for <?php echo $category_name; ?></caption>
            <thead>
                <tr>
                    <th scope="col">Identifier</th>
                    <th scope="col">Project Name</th>
                    <th scope="col" class="right">Price</th>
                    <th scope="col">Description</th>
                    <th scope="colgroup" colspan="2" class="sr-only">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product) : ?>
            <tr>
                <td><?php echo $product['productCode']; ?></td>
                <td><?php echo $product['productName']; ?></td>
                <td class="right"><?php echo $product['listPrice']; ?></td>
                <td><?php echo $product['description']; ?></td>
                <td>
                    <form action="modify_product.php" method="post">
                        <input type="hidden" name="product_id"
                            value="<?php echo $product['productID']; ?>">
                        <input type="hidden" name="category_id"
                            value="<?php echo $product['categoryID']; ?>">
                        <button type="submit" aria-label="Modify <?php echo $product['productName']; ?>">Modify</button>
                    </form>
                </td>
                <td>
                    <form action="delete_product.php" method="post">
                        <input type="hidden" name="product_id"
                            value="<?php echo $product['productID']; ?>">
                        <input type="hidden" name="category_id"
                            value="<?php echo $product['categoryID']; ?>">
                        <button type="submit" aria-label="Delete <?php echo $product['productName']; ?>">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p><a href="add_product_form.php">Add a New Project</a></p>
        <p><a href="category_list.php">Manage Workshops</a></p>
    </section>
</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Softstack Studios. All Rights Reserved.</p>
</footer>
</body>
</html>
