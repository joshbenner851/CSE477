/**
 * Created by joshbenner on 4/17/16.
 */
function Languages(sel) {
    var form = $(sel);

    form.submit(function(event) {
        event.preventDefault();
        $(sel + " .result").html("<p>Searching</p>");
        $.ajax({
            url: "post.php",
            data: form.serialize(),
            method: "GET",
            success: function(data) {
               $(sel + " .result").html(data);
                $(sel + " .result").hide().fadeIn(500);
            },
            error: function(xhr, status, error) {
                $(sel + " .result").html("<p>Error: " + error + "</p>");
            }
        });
        console.log("submit");
    });

}