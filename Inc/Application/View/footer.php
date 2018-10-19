<script>
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

    function display(){
        var button = document.getElementById("addNew");
        var form = document.getElementById("submitForm");

        form.style.display = "block";
    }

    function remove(){
        //var remove = document.getElementById("remove");
        var result = document.getElementsByClassName('result');
        alert(result.length);
    }

</script>
</body>
</html>