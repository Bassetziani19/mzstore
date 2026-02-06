<?php
require_once 'db.php';
require_once 'functions.php';

// Fetch all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MZ Store - Modern Fashion</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="logo">MZ STORE</div>
        <ul class="nav-links">
            <li><a href="index.php" class="active">Acceuil</a></li>
            <li><a href="#products">Collection</a></li>
        </ul>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <h1>Elevate Your Style</h1>
            <p>Découvrez les dernières tendances de la mode moderne.</p>
            <a href="#products" class="btn">Acheter Maintenant</a>
        </div>
    </header>

    <section id="products" class="container">
        <h2 class="section-title">Nouvelle Collection</h2>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
            <a href="product.php?id=<?php echo $product['id']; ?>" class="product-card">
                <div class="product-image">
                    <?php if($product['image']): ?>
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php else: ?>
                    <div class="no-image">No Image</div>
                    <?php endif; ?>
                </div>
                <div class="product-info">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="price"><?php echo formatPrice($product['price']); ?></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-col">
                <h3>MZ STORE</h3>
                <p>Votre destination pour la mode moderne et élégante. Nous offrons les meilleures collections pour hommes, femmes et enfants.</p>
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
                    <li><a href="#products">Collection</a></li>
                    <li><a href="admin/login.php">Admin Login</a></li>
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

    <script src="script.js"></script>
</body>
</html>
