<?php
require "../includes/config.php";
$user = new User();
$user->checkLogin();

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$p = new Product;
$product = $p->get($id);
$pc = new ProductComment();

echo "<h1>$product[title]</h1>";
echo "<div>price: $product[price]</div>";

$comments = $pc->getAll($id);
?>

<ul>
    <?php
    foreach ($comments as $comment) {
        echo "<li><h3>$comment[firstname] $comment[lastname]</h3>"
        . "<div>pos: $comment[pos], neg: $comment[neg]"
        . "<a href='comment-score.php?commentId=$comment[id]&type=pos'>+</a>"
        . "<a href='comment-score.php?commentId=$comment[id]&type=neg'>-</a>"
        . "$comment[text]</div>"
        . "</li>";
    }
    ?>
</ul>



<form action="post-comment.php" method="post">
    <input name="productId" value="<?= $id ?>" type="hidden">
    Command: <textarea name="text"></textarea><br>
    <input type="submit" value="send">
</form>