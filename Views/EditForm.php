<?php include $_SERVER['DOCUMENT_ROOT'] . "/Autoload.php";
$model = new \Model\Model();
$word = "";
$label = "";
$tableName = "";
$id = "";
if (isset($_GET['editword'])) {
    $label = "Word";
    $tableName = "words";
    $id = $_GET['editword'];
    $word = $model->get('words', $_GET['editword'])[0]['word'];
} elseif (isset($_GET['editpattern'])) {
    $label = "Pattern";
    $tableName = "patterns";
    $id = $_GET['editpattern'];
    $word = $model->get('patterns', $_GET['editpattern'])[0]['pattern'];
}
?>
<div class="formWrapper">
    <form action="/formHandler.php?<?php echo $tableName;?>=<?php echo $id; ?>" method="post">
        <label for="">Edit <?php echo $label;?></label>
        <input type="text" name="word" placeholder="New Word" value="<?php echo $word;?>">
        <input type="submit" name="update" value="Update">
    </form>
</div>
</div>