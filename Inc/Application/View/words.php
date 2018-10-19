<div class="results">
    <div class="wrapper">
        <div class="header">
            <h1>Words</h1>
        </div>
        <?php foreach($data as $row):?>
        <div class="showResult">
            <div class="result"><?php echo $row['word'];?></div>
            <div class="edit"><a href="#">Edit</a></div>
            <div class="delete"><a href="#">Delete</a></div>
        </div>
        <?php endforeach;?>
    </div>