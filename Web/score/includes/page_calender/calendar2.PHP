<html>
<head>
<link rel="stylesheet" href="calender.css">
<Title>Kalender</Title>
</head>
<body topmargin="5" leftmargin="5">

<script language=javascript>
var minYear  = 1950;
var maxYear  = 2050;
var minMonth = 0;
var maxMonth = 11;

function formatDate(argDate) {
  var tmpYear  = String(argDate.getFullYear());
  var tmpMonth = String(argDate.getMonth()+1);
  var tmpDate  = String(argDate.getDate());

  tmpDate  = ((tmpDate.length==1)? '0':'')  + String(tmpDate);
  tmpMonth = ((tmpMonth.length==1)? '0':'') + String(tmpMonth);
 
  //return(tmpDate + '/' + tmpMonth + '/' + tmpYear);
  return(tmpYear + tmpMonth + tmpDate);
}

function getDayLabel(argNum) {
  switch(argNum) {
    case 0: return('Minggu'); case 1: return('Senin'); case 2: return('Selasa');
    case 3: return('Rabu'); case 4: return('Kamis'); case 5: return('Jumat');
    case 6: return('Sabtu');
  }
}

function getMonthLabel(argNum) {
  switch(argNum) {
    case 0: return('Januari');    case 1:  return('Februari');  case 2:  return('Maret');
    case 3: return('April');      case 4:  return('Mei');       case 5:  return('Juni');
    case 6: return('Juli');       case 7:  return('Agustus');  case 8:  return('September');  
    case 9: return('Oktober');    case 10: return('Nopember');  case 11: return('Desember');
  }
}

today = new Date();
useMonth = today.getMonth();
useYear  = today.getFullYear();

hT = '';

hT+= '<table><tr><td><select id="selMonth" class="selSelect" onchange="useMonth=this.value;writeDate();">';
for (var i=minMonth; i<=maxMonth; i++)
  hT+= '<option value="' + i + '" ' +  ((i==useMonth)?'SELECTED':'') + '>' + getMonthLabel(i) + '</option>';
hT+= '</select></td>';

hT+= '<td align=right><select id="selYear" class="selSelect" onchange="useYear=this.value;writeDate();">';
for (var i=minYear; i<=maxYear; i++)
  hT+= '<option value="' + i + '" ' +  ((i==useYear)?'SELECTED':'') + '>' + i + '</option>';
hT+= '</select></td></tr>';

hT+= '<tr><td colspan=2><div id="calendar" style="width: "></div></td></tr>';
hT+= '<tr><td colspan=2>';

hT+= '<table class="scrollMenu" cellpadding=0 cellspacing=0 border=0 width=100%>';
hT+= '<tr>';
hT+= '<td align=center width=15%><div onclick="showPrevYear()">&lt;&lt;</div></td>';
hT+= '<td align=center width=15%><div onclick="showPrevMonth()">&lt;</div></td>';
hT+= '<td align=center><div onclick="showToday()">Counter</dvi></td>';
hT+= '<td align=center width=15%><div onclick="showNextMonth()">&gt;</div></td>';
hT+= '<td align=center width=15%><div onclick="showNextYear()">&gt;&gt;</div></td>';
hT+= '</tr>';

hT+= '</table>';


hT+= '</td></tr>';
hT+= '</table>';



document.write(hT);

function setSelected(argSelBoxRef, argValue) {
  for (var z=0; z<argSelBoxRef.options.length; z++) 
    argSelBoxRef.options[z].selected = (argSelBoxRef.options[z].value == argValue);
}

function showPrevYear() {
  var yearSel = document.getElementById('selYear');

  useMonth = document.getElementById('selMonth').value;
  useYear  = yearSel.value;
  useYear--;
  if (useYear < minYear) useYear = maxYear;
  setSelected(yearSel, useYear);
  writeDate(); 
}

function showNextYear() {
  var yearSel = document.getElementById('selYear');

  useMonth = document.getElementById('selMonth').value;
  useYear  = yearSel.value;
  useYear++;
  if (useYear > maxYear) useYear = minYear;
  setSelected(yearSel, useYear);
  writeDate(); 
}

function showPrevMonth() {
  var monthSel = document.getElementById('selMonth');

  useYear = document.getElementById('selYear').value;
  useMonth  = monthSel.value;
  useMonth--;
  if (useMonth < minMonth) {
    showPrevYear();
    useMonth = maxMonth;
  }
  setSelected(monthSel, useMonth);
  writeDate(); 
}

function showNextMonth() {
  var monthSel = document.getElementById('selMonth');

  useYear = document.getElementById('selYear').value;
  useMonth  = monthSel.value;
  useMonth++;
  if (useMonth > maxMonth) {
    showNextYear();
    useMonth = minMonth;
  }
  setSelected(monthSel, useMonth);
  writeDate(); 
}

function showToday() {
  var monthSel = document.getElementById('selMonth');
  var yearSel = document.getElementById('selYear');
  useMonth = today.getMonth();
  useYear  = today.getFullYear();
  setSelected(monthSel, useMonth);
  setSelected(yearSel, useYear);
  writeDate(); 
}

function writeDate()
{
  var tdextra='';
  var stylecls='';
  var oneDay = 86400000;
  var countDate = new Date( useYear, useMonth, 1);
  countDate = new Date( countDate.valueOf() - ( countDate.getDay() * oneDay) ); 

  hT = '';
  hT+= '<table border=0>';
  for (var r=0; r<7; r++) {
    hT += '<tr>';
    for (var c=0; c<7; c++) {
      if (r==0) {
	   tdextra = 'class="weekDays" align="center"';
       cell = getDayLabel(c); 
      }
      else {
        if (countDate.getMonth() == useMonth )
          stylecls = ( ((countDate.getDate()     == today.getDate()     ) && 
                        (countDate.getFullYear() == today.getFullYear() ) &&
                        (countDate.getMonth()    == today.getMonth()    ) )? 'rightday' : 'rightmonth' );
        else 
          stylecls = 'wrongmonth';
        cell = '&nbsp;' + countDate.getDate() + '&nbsp;';
        tdextra = 'class="' + stylecls + '" onclick="sendData(\'' + formatDate(countDate) + '\');"  align=right';
      }
            
      hT += '<td ' + tdextra + '>' + cell + '</td>';
     
      if (r!=0) countDate = new Date(countDate.valueOf() + oneDay );
    }
    hT += '</tr>';
  }
  hT+= '</table>';
  document.getElementById('calendar').innerHTML = hT;
}

writeDate();

function sendData(mdate) {
	opener.document.<? $frmName = $_GET["frmName"]; echo $frmName?>.<? $fieldName = $_GET["fieldName"]; echo $fieldName?>.value = mdate ;
	<? 
	if ($nextFieldName != null) { 
	$tmpString = "opener.document.";
	$tmpString .= $frmName;
	$tmpString .= ".";
	$tmpString .= $nextFieldName;
	$tmpString .= ".focus();";
	echo $tmpString;
	}?>
	self.close();
}

</script>
</body>
</html>
