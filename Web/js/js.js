
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

function onMenu(str) {
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

function menuButton(id, str) {
//               alert(id);
    //   var newURL = '';
    if (id == 1) {

        location.href = '?content=' + str;

    } else {
        location.href = '?content=' + str;
    }


//     newwindow = location.href(newURL);
//    if (window.focus) {
//        newwindow.focus();
//    }

    return false;
    //  getJavascript(str);

}


function moneyFormats(number) {
//	alert( number );
//	var price	  = number.split('.');
//	if(isNaN(price[0])) return "";
    var str = new String(number);

//	alert( str.length ); 
    var result = "", len = str.length;
    for (var i = len - 1; i >= 0; i--) {
        if ((i + 1) % 3 == 0 && i + 1 != len)
            result += ",";
        result += str.charAt(len - 1 - i);
    }
    var newPrice = result;
    return newPrice;
}

function moneyFormat(number) {
    var price = number.split('.');
    if (isNaN(price[0]))
        return "";
    var str = new String(price[0]);
    var result = "", len = str.length;
    for (var i = len - 1; i >= 0; i--) {
        if ((i + 1) % 3 == 0 && i + 1 != len)
            result += ",";
        result += str.charAt(len - 1 - i);
    }
    var newPrice = result;
    return newPrice;
}

function formatAmount(id) {
    //  alert(id);
    $('#' + id).blur(function () {
        $("#" + id).html(null);
        $(this).formatCurrency({colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: 0});
    })
            .keyup(function (e) {
                var e = window.event || e;
                var keyUnicode = e.charCode || e.keyCode;
                if (e !== undefined) {
                    switch (keyUnicode) {
                        case 16:
                            break; // Shift
                        case 27:
                            this.value = '';
                            break; // Esc: clear entry
                        case 35:
                            break; // End
                        case 36:
                            break; // Home
                        case 37:
                            break; // cursor left
                        case 38:
                            break; // cursor up
                        case 39:
                            break; // cursor right
                        case 40:
                            break; // cursor down
                        case 78:
                            break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
                        case 110:
                            break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
                        case 190:
                            break; // .
                        default:
                            $(this).formatCurrency({colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: -1, eventOnDecimalsEntered: true});
                    }
                }
            });
}

function searchProyek() {
  // alert("masuk");
    var fieldsearch = $('#sys_txt_keyword').val();
    
    location.href = '?content=search-proyek&parameter=' + fieldsearch;

    return false;
    

}