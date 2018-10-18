<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Autoload.php";
$controller = new Controller\Controller();
$controller->index();
$words = $controller->model->getAllPatterns();
?>
</div>
<div class="results">
    <div class="wrapper">
        <div class="header">
            <h1>Showing: Patterns</h1>
        </div>
        <?php foreach ($words as $row): ?>
            <div class="showResult">
                <div class="result"> <?php echo $row['pattern'];?> </div>
                <div class="edit"><a href="?editpattern=<?php echo $row['id'];?>">Edit</a></div>
                <div class="delete"><a href="delete?id=<?php echo $row['id'];?>">Delete</a></div>
            </div>
        <?php endforeach;?>
    </div>