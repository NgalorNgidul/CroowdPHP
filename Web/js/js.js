
$(function () {

/*    $(document).ready(function () {
        $('a[href^="#"]').on('click', function (e) {
     //       alert("tes");
            //   e.preventDefault();

          //  alert("Button clicked, id " + this.id);
            var str;
            str = this.id;
            if (str == 'sidr-id-allpages') {
                str = 'allpages';
            } else if (str == 'sidr-id-help') {
                str = 'help';
            } else if (str == 'sidr-id-contact') {
                str = 'contact';
            }
          //  alert(str);
            $.ajax({
                type: 'get',
                url: 'index2.php',
                data: 'content=' + str,
                success: function (result) {
                    $('#setBodys').html(result);
                    getJavascript(str);
                }
            });


        });
    });
    */

});

function onMenu(str){
    $.ajax({
                type: 'get',
                url: 'index2.php',
                data: 'content=' + str,
                success: function (result) {
                    $('#setBodys').html(result);
                    getJavascript(str);
                }
            });
}
function getJavascript(str) {
    $.getScript("component/" + str + "/" + str + ".js", function () {
    });
}