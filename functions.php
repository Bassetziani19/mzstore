<?php
session_start();
function redirect($url) { header("Location: $url"); exit; }
function isLoggedIn() { return isset($_SESSION['admin_id']); }
function requireLogin() { if (!isLoggedIn()) { redirect('login.php'); } }
function uploadImage($file) {
    if (!isset($file['name']) || empty($file['name'])) return false;
    $isInAdmin = strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false;
    $targetDir = ($isInAdmin ? "../" : "") . "uploads/";
    if (!file_exists($targetDir)) { mkdir($targetDir, 0777, true); }
    $fileName = basename($file["name"]);
    $uniqueName = uniqid() . "_" . $fileName;
    $targetFilePath = $targetDir . $uniqueName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $webPath = "uploads/" . $uniqueName;
    $allowTypes = array('jpg','png','jpeg','gif','webp');
    if(in_array(strtolower($fileType), $allowTypes)){
        if(move_uploaded_file($file["tmp_name"], $targetFilePath)){ return $webPath; }
    }
    return false;
}
function formatPrice($price) { return number_format((float)$price, 2) . ' DA'; }
?>
