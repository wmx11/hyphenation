//Add new word or pattern
$(document).ready(function () {
    $('#form').on('submit', function (e) {
        var word = $('#word').val();
        var select = $('#select').val();
        var string = 'table=' + select + '&word=' + word;
        if (word == '' || select == '') {
            e.preventDefault();
            alert("Field is required");
        } else {
            $.ajax({
                type: "POST",
                url: '/index.php/submit/insert',
                data: string,
                success: function () {
                    $("#submitForm").css("display", "block");
                }
            });
        }
    });
});

$(document).ready(function() {
    var patterns = $(".showResultPattern");
    var words = $(".showResultWord");
    var stats = $(".statsWrapper");

    patterns.css("transition", "0.15s");
    patterns.css("margin-left", "10px");

    words.css("transition", "0.15s");
    words.css("margin-left", "10px");

    stats.css("margin-left", "10px");
    setTimeout(function(){
        patterns.css("opacity", "1");
        patterns.css("margin-left", "0px");

        words.css("opacity", "1");
        words.css("margin-left", "0px");
        stats.css("margin-left", "0px");

        stats.css("opacity", "1");
    },100);
})

//Display add form
function display() {
    var button = document.getElementById("addNew");
    var form = document.getElementById("submitForm");

    form.style.opacity = 0;
    form.style.display = "block";
    form.style.transition = "0.1s";
    setTimeout(function() {
        form.style.opacity = 1;
    },100);
}

//Pattern Delete
$(document).ready(function () {
    $(".showResultPattern .delete").click(function () {
        var patternId = $(this).parent().attr("id");
        var result = $("#" + patternId).children(".result").text();
        var resultWrapper = $("#" + patternId + ".showResultPattern");
        var string = 'pattern=' + result;
        $.ajax({
            type: "POST",
            url: "/index.php/patterns/delete",
            data: string,
            success: function () {
                resultWrapper.fadeOut(400, function () {
                    resultWrapper.remove()
                });
            }
        });
    });
});

//Word Delete
$(document).ready(function () {
    $(".showResultWord .delete").click(function () {
        var wordId = $(this).parent().attr("id");
        var result = $("#" + wordId).children(".result").text();
        var resultWrapper = $("#" + wordId + ".showResultWord");
        var string = 'word=' + result;
        $.ajax({
            type: "POST",
            url: "/index.php/words/delete",
            data: string,
            success: function () {
                resultWrapper.css("background", "red");
                resultWrapper.fadeOut(400, function () {
                    resultWrapper.remove()
                });
            }
        });
    });
});

// Word Editing
$(document).ready(function () {
    $(".showResultWord .edit").mouseup(function () {
        var popup = $("#editPopup");
        popup.css('display', 'flex');
        setTimeout(function() {
            popup.css('opacity', '1');
        },100)
        var wordId = $(this).parent().attr("id");
        var result = $("#" + wordId).children(".result").text();
        var resultWrapper = $("#" + wordId + ".showResultWord");
        $("#editWord").val(result);
        $("#editForm").on('submit', function (e) {
            $.ajax({
                type: "POST",
                url: "/index.php/words/edit",
                data: 'word=' + result + '&editedWord=' + $("#editWord").val(),
                success: function () {
                }
            });
        });
    });
    $("#editPopup").click(function (e) {
        var popup = $("#editPopup");
        if (!$(e.target).closest("#editWord").length) {
            popup.fadeOut(200);
            popup.css('opacity', '0');
        }
    })
});

//Pattern Editing
$(document).ready(function () {
    $(".showResultPattern .edit").mouseup(function () {
        var popup = $("#editPopup");
        popup.css('display', 'flex');
        setTimeout(function() {
            popup.css('opacity', '1');
        },100)
        var wordId = $(this).parent().attr("id");
        var result = $("#" + wordId).children(".result").text();
        var resultWrapper = $("#" + wordId + ".showResultPattern");
        $("#editWord").val(result);
        $("#editForm").on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/index.php/patterns/edit",
                data: 'pattern=' + result + '&editedPattern=' + $("#editWord").val(),
                success: function () {
                }
            });
        });
    });
    $("#editPopup").click(function (e) {
        if (!$(e.target).closest("#editWord").length) {
            popup.fadeOut(200);
            popup.css('opacity', '0');
        }
    })
});
