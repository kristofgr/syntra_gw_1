<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}

require('ENV.php');
require('includes/db.inc.php');

$sort = "id";
if (isset($_GET['sort']) && in_array($_GET['sort'], ['name', 'status', 'date_created'])) {
    $sort = $_GET['sort'];
}

$categories = getCategories();
$products = getProducts($sort);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>private admin webpage</title>
    <?php include("includes/cs.inc.php"); ?>
</head>

<body>


    <div class="container">
        <p><a href="logout.php">Log out</a></p>
        <p>Welcome,
            <?= $_SESSION['username']; ?>
        </p>

        <h1>Products</h1>

        <a href="add.php">Toevoegen</a>

        <form method="get" action="index.php">
            <select id="filter_category" name="filter_category">
                <?php foreach ($categories as $key => $category): ?>
                    <option value="<?= $key; ?>">
                        <?= $category; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">filter</button>
        </form>


        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col"><a href="?sort=name">Name</a></th>
                    <th scope="col">Image</th>
                    <th scope="col"><a href="?sort=status">Status</a></th>
                    <th scope="col"><a href="?sort=date_created">Created</a></th>
                    <th scope="col">Updated</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <th scope="row">
                            <?= $product->id; ?>
                        </th>
                        <td>
                            <?= $product->name; ?>
                        </td>
                        <td>
                            <?= $product->image; ?>
                        </td>
                        <td>
                            <?= $product->status == 1 ? 'published' : 'unpublished'; ?>
                        </td>
                        <td>
                            <?= $product->date_created; ?>
                        </td>
                        <td>
                            <?= $product->date_updated ? $product->date_updated : '-'; ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $product->id; ?>">edit</a>
                            <a href="delete.php?id=<?= $product->id; ?>">delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
        </table>
    </div>



    <button class=" btn btn-primary">knop</button>
    <button class="btn btn-secondary">knop</button>
    <button class="btn btn-primary btn-disabled">knop</button>
    <div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Bootstrap</strong>
                <small>11 mins ago</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
        </div>
    </div>
</body>

</html>