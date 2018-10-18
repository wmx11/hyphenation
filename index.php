<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Inc/Resources/Autoload.php";
$controller = new Controller\Controller();
$controller->index();
$model = new Model\Model;
$words = $model->getAllWords();
?>
<div class="results">
    <div class="wrapper">
        <div class="header">
            <h1>Showing: <a href="Views/Words.php">Words</a></h1>
        </div>
        <?php foreach ($words as $row): ?>
        <div class="showResult">
            <div class="result"> <?php echo $row['word'];?> </div>
            <div class="edit"><a href="edit?id=<?php echo $row['id'];?>">Edit</a></div>
            <div class="delete"><a href="delete?id=<?php echo $row['id'];?>">Delete</a></div>
        </div>
        <?php endforeach;?>
</div>