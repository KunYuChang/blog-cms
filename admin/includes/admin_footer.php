</div>
    <!-- /#wrapper -->

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script src="js/runSummerNote.js"></script>
    <script src="js/script.js"></script>

    <script>
        $(window).load(function() {
            $('#load-screen').fadeOut();
        });

        function loadUsersOnline() {
    
            $.ajax({
                url: "functions.php",
                type: "GET",
                data: {
                    onlineusers: "result"
                },
                success: function(data) {
                    console.log(data);
                    $(".usersonline").text(data);
                },
                error: function(xhr, status, error) {
                    console.log("Error loading online users:", error);
                }
            });
        }
        
        setInterval(function() {
            loadUsersOnline();
        }, 500);

    </script>
</body>

</html>