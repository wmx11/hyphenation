<div class="results">
    <div class="wrapper">
        <div class="header">
            <h1>Words</h1>
        </div>
        <?php foreach($data as $id => $row):?>
        <div class="showResultWord" id="<?php echo $id;?>">
            <div class="result" id="<?php echo $id;?>"><?php echo $row['word'];?></div>
            <div class="edit" id="<?php echo $id;?>"><a href="#">Edit</a></div>
            <div class="delete" id="<?php echo $id;?>"><a href="#">Delete</a></div>
        </div>
        <?php endforeach;?>
    </div>