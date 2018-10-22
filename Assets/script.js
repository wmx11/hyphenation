//Add new word or pattern
$(document).ready(function(){
    $('#form').on('submit', function(e){
        var word = $('#word').val();
        var select = $('#select').val();
        var string = 'table='+select+'&word='+word;
        if (word == '' || select =='') {
            e.preventDefault();
            alert("Field is required");
        } else {
            $.ajax({
                type: "POST",
                url: '/main.php/Words/submit',
                data: string,
                success: function(){
                    console.log('Submitted');
                }
            });
        }
    });
});

//Display add form
function display(){
    var button = document.getElementById("addNew");
    var form = document.getElementById("submitForm");

    form.style.display = "block";
}

//Pattern Delete
$(document).ready(function() {
    $(".showResultPattern .delete").click(function() {
        var patternId = this.id;
        var result = $("#"+patternId+".result").text();
        var resultWrapper = $("#"+patternId+".showResultPattern");
        var string = 'pattern='+result;
        $.ajax({
            type: "POST",
            url: "/main.php/patterns/delete",
            data: string,
            success: function(){
                resultWrapper.fadeOut(400, function() {
                    resultWrapper.remove()
                });
            }
        });
    });
});

//Word Delete
$(document).ready(function() {
    $(".showResultWord .delete").click(function() {
        var wordId = this.id;
        var result = $("#"+wordId+".result").text();
        var resultWrapper = $("#"+wordId+".showResultWord");
        var string = 'word='+result;
        $.ajax({
            type: "POST",
            url: "/main.php/words/delete",
            data: string,
            success: function(){
                resultWrapper.fadeOut(400, function() {
                    resultWrapper.remove()
                });
            }
        });
    });
});

// Word Editing
$(document).ready(function() {
    $(".showResultWord .edit").mouseup(function() {
        $("#editPopup").show().css('display', 'flex');
        var wordId = this.id;
        var result = $("#"+wordId+".result").text();
        var resultWrapper = $("#"+wordId+".showResultWord");
        $("#editWord").val(result);

        $("#editForm").on('submit', function() {
            $.ajax({
                type: "POST",
                url: "/main.php/words/edit",
                data: 'word='+result+'&editedWord='+$("#editWord").val(),
                success: function() {
                }
            });
        });
    });
    $("#editPopup").click(function(e) {
        if(!$(e.target).closest("#editWord").length) {
            $("#editPopup").fadeOut(100);
        }
    })
});

//Pattern Editing
$(document).ready(function() {
    $(".showResultPattern .edit").mouseup(function() {
        $("#editPopup").show().css('display', 'flex');
        var wordId = this.id;
        var result = $("#"+wordId+".result").text();
        var resultWrapper = $("#"+wordId+".showResultPattern");
        $("#editWord").val(result);

        $("#editForm").on('submit', function() {
            $.ajax({
                type: "POST",
                url: "/main.php/patterns/edit",
                data: 'pattern='+result+'&editedPattern='+$("#editWord").val(),
                success: function() {
                }
            });
        });
    });
    $("#editPopup").click(function(e) {
        if(!$(e.target).closest("#editWord").length) {
            $("#editPopup").fadeOut(100);
        }
    })
});
