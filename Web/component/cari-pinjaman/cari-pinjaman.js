$(function () {
    // alert('alert');
    $('#messagefieldmax').hide();
    itemTerm();
    //  $('#txt_get_loan').autoNumeric('init');    
    var getOption = $.parseJSON('{"mDec": 0}');
//		$('#txt_get_loan').autoNumeric('update', getOption);
    $('#txt_get_loan').autoNumeric('init', getOption);


});

function itemTerm() {
    //  var getloan = $('#txt_get_loan').val();
    var tempPrice = $("#txt_get_loan").val().split(",");
    var getloan = '';
    for (var a = 0; a < tempPrice.length; a++) {
        getloan += tempPrice[a];
    }
    var maxmoney = 100000000;
    if (getloan >= maxmoney) {
        var getloans = maxmoney;
        $("#txt_get_loan").val(getloans);
        $('#messagefieldmax').show();

    } else {
        $('#messagefieldmax').hide();

        var totalitem = $('#totalitem').val();


//    alert(getloan);
        var include = '';
        for (var i = 0; i < totalitem; i++) {
            var no = parseFloat(i) + 1;
            var jumlahterm;
            var bunga;
            switch (no) {
                case 1:
                    jumlahterm = 12;
                    bunga = 5;
                    break;
                case 2:
                    jumlahterm = 24;
                    bunga = 10;
                    break;
                case 3:
                    jumlahterm = 36;
                    bunga = 15;
                    break;
                case 4:
                    jumlahterm = 48;
                    bunga = 20;
                    break;
                case 5:
                    jumlahterm = 60;
                    bunga = 25;
                    break;
                default:
                    break;
            }

            var tambahbunga = bunga * getloan / 100;
            //   alert("tambah bunga : "+tambahbunga);
            var hasilloan = parseFloat(getloan) + parseFloat(tambahbunga);
            //   alert("hasilloan : "+hasilloan);
            var perbulan = hasilloan / jumlahterm;




            include = include + '<tr id="tr' + no + '">';
            include = include + '<td id="term' + no + '" style="width:50%"><input type="radio" name="cek" value="' + no + '" onclick="pilihTerm(' + no + ');"> ' + no + ' Years<input type="hidden" id="termfield' + no + '" value="' + no + '"/></td>';
            include = include + '<td id="apr' + no + '" style="width:25%;text-align:center;">' + bunga + ' %<input type="hidden" id="bungafield' + no + '" value="' + bunga + '"/></td>';
            include = include + '<td id="month' + no + '" style="width:25%;text-align:right;">' + moneyFormat(perbulan.toFixed(2)) + ' IDR<input type="hidden" id="perbulanfield' + no + '" value="' + perbulan + '"/></td>';
            include = include + ' </tr>';
        }

        $('#itemTerm').html(include);
    }
    //      formatAmount('txt_get_loan');

    //  alert(getloan);
}

function pilihTerm(no) {
 //   alert(no);
    var termfield = $('#termfield' + no).val();
    var bungafield = $('#bungafield' + no).val();
    var perbulanfield = $('#perbulanfield' + no).val();
    $('#termpilih').val(termfield);
    $('#bungapilih').val(bungafield);
    $('#perbulanpilih').val(perbulanfield);

}

function sendButton() {
   var termpilih = $('#termpilih').val();
   var bungapilih = $('#bungapilih').val();
   var perbulanpilih = $('#perbulanpilih').val();
    if (termpilih == '' && bungapilih == '' && perbulanpilih  == '') {
        alert("Mohon Pilih Salah Satu Term yang anda butuhkan");
    } else {
        location.href = '?content=cari-pinjaman&termpilih'+termpilih+'&bungapilih='+bungapilih+'&perbulanpilih='+perbulanpilih;

    }


    return false;

}