<div class="results">
    <div class="wrapper">
        <div class="header">
            <h1>Patterns</h1>
        </div>
        <?php foreach ($data['patterns'] as $id => $row): ?>
            <div class="showResultPattern" id="<?php echo $id; ?>">
                <div class="result" id="<?php echo $id; ?>"> <?php echo $row['pattern'] ?> </div>
                <div class="edit" id="<?php echo $id; ?>"><a href="#">Edit</a></div>
                <div class="delete" id="<?php echo $id; ?>"><a href="#">Delete</a></div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class='pagination'>
        <?php $data['paginate']->paginate(); ?>
    </div>