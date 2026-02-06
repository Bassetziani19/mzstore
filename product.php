<?php
require_once 'db.php';
require_once 'functions.php';

if (!isset($_GET['id'])) { redirect('index.php'); }

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) { redirect('index.php'); }

// Handle Direct Order Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $qty = (int)$_POST['quantity'];
    
    if ($qty < 1) $qty = 1;

    $total_amount = $product['price'] * $qty;

    $stmt = $pdo->prepare("INSERT INTO orders (client_name, client_email, client_phone, client_address, total_amount, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([$name, $email, $phone, $address, $total_amount]);
    $order_id = $pdo->lastInsertId();

    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_time) VALUES (?, ?, ?, ?)");
    $stmt->execute([$order_id, $product['id'], $qty, $product['price']]);

    $success_msg = "Votre commande a été reçue ! Nous vous contacterons bientôt pour confirmation.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - MZ Store</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="logo">MZ STORE</div>
        <ul class="nav-links">
            <li><a href="index.php">Acceuil</a></li>
        </ul>
    </nav>

    <div class="container product-detail-container">
        <div class="product-detail-image">
            <?php if($product['image']): ?>
            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <?php else: ?>
            <div class="no-image">No Image</div>
            <?php endif; ?>
        </div>
        <div class="product-detail-info">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="category"><?php echo htmlspecialchars($product['category']); ?></p>
            <p class="price"><?php echo formatPrice($product['price']); ?></p>
            <p class="description"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            
            <?php if (isset($success_msg)): ?>
                <div class="success-message">
                    <?php echo $success_msg; ?>
                </div>
                <a href="index.php" class="btn">Retour à l'accueil</a>
            <?php else: ?>
                <div class="order-form">
                    <h2>Commander maintenant</h2>
                    <form method="POST">
                        <div class="quantity-control">
                            <label>Quantité:</label>
                            <input type="number" name="quantity" value="1" min="1">
                        </div>
                        <div class="form-group">
                            <label>Nom Complet</label>
                            <input type="text" name="name" required placeholder="Votre nom">
                        </div>
                        <div class="form-group">
                            <label>Numéro de Téléphone</label>
                            <input type="tel" name="phone" required placeholder="00 000 000">
                        </div>
                        <div class="form-group">
                            <label>Adresse</label>
                            <textarea name="address" rows="2" required placeholder="Votre adresse de livraison"></textarea>
                        </div>
                        <div class="form-group">
                             <label>Email (Optionnel)</label>
                             <input type="email" name="email" value="client@example.com">
                        </div>

                        <button type="submit" name="place_order" class="btn btn-large full-width">Confirmer la Commande</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-col">
                <h3>MZ STORE</h3>
                <p>Votre destination pour la mode moderne et élégante.</p>
                <div class="social-links">
                   <a href="#">F</a>
                   <a href="#">I</a>
                   <a href="#">T</a>
                </div>
            </div>
            <div class="footer-col">
                <h3>Liens Rapides</h3>
                <ul class="footer-links">
                    <li><a href="index.php">Acceuil</a></li>
                    <li><a href="index.php#products">Collection</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Contact</h3>
                <ul class="footer-links">
                    <li><a href="#">+213 555 123 456</a></li>
                    <li><a href="#">contact@mzstore.com</a></li>
                    <li><a href="#">Alger, Algérie</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2024 MZ Store. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
