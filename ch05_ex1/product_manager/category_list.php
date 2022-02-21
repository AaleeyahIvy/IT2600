<?php include '../view/header.php';?> 
<!DOCTYPE html>
<html>
<head>
    <title>My Guitar Shop</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
<header><h1>Product Manager</h1></header>
<main>
    <h1>Category List</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach ($categories as $category) : ?>
	<tr>
            <td><?php echo $category['categoryName']; ?></td>
            <td><form action="index.php" method="post">
                <input type="hidden" name="category_id"
                       value="<?php echo $category['categoryID']; ?>">
                <input type="hidden" name="action" value="delete_category">
                <input type="submit" value="Delete">
            </form></td>
	</tr>
        <?php endforeach; ?>
    </table>
    <h2>Add Category</h2>
        <form action="index.php" method="post" id="add_category_form"> 
        <label>Name</label>
        <input type="hidden" name="action" value="add_category">
        <input type="text" name="name">
        <input id="add_category_button" type="submit" value="Add">
    </form>
    <br>
    <p><a href="index.php">List Products</a></p>
    </main>
<?php include '../view/footer.php'; ?>