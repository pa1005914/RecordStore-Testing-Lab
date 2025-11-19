<?php
    include __DIR__ . "/data/db.php";
    include __DIR__ . "/data/functions.php";

    #starts a secsion to save the data from the login
    session_start();

    $view   = filter_input(INPUT_GET, 'view') ?: 'list';
    $action = filter_input(INPUT_POST, 'action');

    #redirects user to login page when the user does not have a user_id in the session from a succesful login
    function require_login(): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: ?view=login');
            exit;
        }
    }

    $public_views   = ['login', 'register'];
    $public_actions = ['login', 'register'];

    if ($action && !in_array($action, $public_actions, true)) {
        require_login();
    }

    if (!$action && !in_array($view, $public_views, true)) {
        require_login();
    }

    #login finds a person from the users table and creates a session for that user
    switch ($action) {
        case 'login':
            $username = trim((string)($_POST['username'] ?? ''));
            $password = (string)($_POST['password'] ?? '');

            if ($username && $password) {
                $user = user_find_by_username($username);
                if ($user && password_verify($password, $user['password_hash'])) {
                    $_SESSION['user_id'] = (int)$user['id'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $view = 'list';
                } else {
                    $login_error = "Invalid username or password.";
                    $view = 'login';
                }
            } else {
                $login_error = "Enter both fields.";
                $view = 'login';
            }
            break;

        case 'logout':
            $_SESSION = [];
            session_destroy();
            session_start();
            $view = 'login';
            break;
        # register creates a new record in the users table and creates a session for said user
        case 'register':
            $username  = trim((string)($_POST['username'] ?? ''));
            $full_name = trim((string)($_POST['full_name'] ?? ''));
            $password  = (string)($_POST['password'] ?? '');
            $confirm   = (string)($_POST['confirm_password'] ?? '');

            if ($username && $full_name && $password && $password === $confirm) {
                $existing = user_find_by_username($username);
                if ($existing) {
                    $register_error = "That username already exists.";
                    $view = 'register';
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    user_create($username, $full_name, $hash);

                    $user = user_find_by_username($username);
                    #adds the created user to the session
                    $_SESSION['user_id'] = (int)$user['id'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $view = 'list';
                }
            } else {
                $register_error = "Complete all fields and match passwords.";
                $view = 'register';
            }
            break;
        # the ids of the records that the user has selected to purchase
        case 'add_to_cart':
            require_login();
            $record_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            #starts a cart for the user or adds the item
            if ($record_id) {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                $_SESSION['cart'][] = $record_id;
            }
            $view = 'list';
            break;
        #purchase all of the items by id in the user's cart
        case 'checkout': 
            require_login();
            $cart_ids = $_SESSION['cart'] ?? [];

            if ($cart_ids) {
                foreach ($cart_ids as $rid) {
                    purchase_create((int)$_SESSION['user_id'], (int)$rid);
                }
                $_SESSION['cart'] = [];
            }
            $view = 'checkout_success';
            break;
        case 'create':
            $title    = trim((string)(filter_input(INPUT_POST, 'title') ?? ''));
            $artist   = trim((string)(filter_input(INPUT_POST, 'artist') ?? ''));
            $price    = (float)(filter_input(INPUT_POST, 'price') ?? 0);
            $format_id = (int)(filter_input(INPUT_POST, 'format_id') ?? 0);
            
            if ($title && $artist && $format_id) {
                record_insert($title, $artist, $price, $format_id);
                $view = 'created';
            } else {
                $view = 'create';
            }
            break;

        case 'delete':
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            if ($id) {
                $deleted = record_delete($id); // returns 1 if a row was deleted
            }
            $view = 'deleted';
            break;

        case 'edit':
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $title     = (string)filter_input(INPUT_POST, 'title',  FILTER_UNSAFE_RAW);
            $artist    = (string)filter_input(INPUT_POST, 'artist', FILTER_UNSAFE_RAW);
            $price_in  =        filter_input(INPUT_POST, 'price',   FILTER_UNSAFE_RAW);
            $format_id  =        filter_input(INPUT_POST, 'format_id', FILTER_VALIDATE_INT);

            $price = is_numeric($price_in) ? (float)$price_in : null;

            if ($id && $title !== '' && $artist !== '' && $price !== null && $format_id) {
                record_update($id, $title, $artist, $price, (int)$format_id);
            }

            $view = 'create';            // reuse the view
            break;
        }
        if ($view === 'cart') {
            $cart_ids = $_SESSION['cart'] ?? [];
            $records_in_cart = records_by_ids($cart_ids);
        }
            
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php include __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'bootstrapcdnlinks.php'; ?>

    <title>Document</title>
</head>
<body> 
        <?php include __DIR__ . DIRECTORY_SEPARATOR .'components' . DIRECTORY_SEPARATOR . 'nav.php'?>
        <?php
        if ($view === 'login') {
            include __DIR__ . '/partials/login_form.php';
        }
        elseif ($view === 'register') {
            include __DIR__ . '/partials/register_form.php';
        }
        elseif ($view === 'cart') {
            include __DIR__ . '/partials/cart.php';
        }
        elseif ($view === 'checkout_success') {
            include __DIR__ . '/partials/checkout_success.php';
        }
        elseif ($view === 'list') {
            include __DIR__ . '/partials/records_list.php';
        }
        elseif ($view === 'create') {
            include __DIR__ . '/partials/record_form.php';
        }
        elseif ($view === 'created') {
            include __DIR__ . '/partials/record_created.php';
        }
        elseif ($view === 'deleted') {
            include __DIR__ . '/partials/record_deleted.php';
        }
        ?>
        <!-- <h2>Unit Test 1 — Formats</h2>
        <table>
            <tr>
            <td>Formats:</td>
        <?php
        $rows = formats_all();
        foreach($rows as $row):
        ?>

        <td><?= $row['name'] ?></td>
        <?php
        endforeach
        ?>
        </tr>
        </table>
        <hr>

        <h2>Unit Test 2 — Records JOIN</h2>
        <table>

        <?php
            $rows = records_all();
            foreach($rows as $row):
        ?>
        <tr>
            <td><?= $row['title']?></td>
            <td><?= $row['artist']?></td>
            <td><?= $row['price']?></td>

        </tr>

                
        <?php
        endforeach;    
        ?>
        </table>
        <hr>

        <h2>Unit Test 3 — Insert</h2>
        <?php //record_insert('Playing God', 'Polyphia', 20.99, 3)?>

        <table>
            <tr>
                <th>Title</th>
                <th>Format</th>
                <th>Price</th>
            </tr>
            <?php
                $rows = records_all();
                foreach($rows as $row):
            ?>
        <tr>
            <td><?= $row['title']?></td>
            <td><?= $row['name']?></td>
            <td><?= $row['price']?></td>

        </tr>
        <?php endforeach;?>
        <hr> -->
</body>
</html>