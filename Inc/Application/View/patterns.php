<div class="results">
    <div class="wrapper">
        <div class="header">
            <h1>Patterns</h1>
        </div>
        <?php foreach($data as $key => $row):?>
        <div class="showResult">
            <div class="result" id="pattern<?php echo $key;?>"> <?php echo $row['pattern']?> </div>
            <div class="edit"><a href="#">Edit</a></div>
            <div class="delete"><a href="#" id="delete" onclick="remove()">Delete</a></div>
        </div>
        <?php endforeach;?>
    </div>