<?php
/*
Free Bulgarian Dictionary Database
Copyright (C) 2012  Vanyo Georgiev <info@vanyog.com>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// ����� html ��� �� ��������� �� ������

global $dpth;

$dpth = dirname(__FILE__).'/';

include_once($dpth.'../../conf_paths.php');
include_once($dpth.'../../lib/f_db_table_field.php');
include_once($dpth.'../../lib/f_db_select_m.php');
include_once($dpth.'../../lib/f_stored_value.php');
include_once($dpth.'f_to_javascript.php');

function bgdic(){

global $pth, $dpth, $database, $user, $password, $db_link, $tn_prefix, $body_adds, $page_header, $idir;

$rpth = $pth.'mod/'.basename($dpth);

$cols = 5;                                 // ���� �� �������� �� ����������
$wc = 1*db_table_field('COUNT(*)', 'w_words', '1'); // ���� �� ������ ���� � ������ �����
if (!$wc) return "���� ���� � ������ �����! ";
$fs = 1*db_table_field('COUNT(*)', 'w_word_forms', '1'); // ���� �� ������ ����� �� ����

$wf = ''; // ����� �� ������, ����� �� �����
$sc = ''; // JavaScript, ����� �� ������ ��� onLoadPage();
if (isset($_GET['wf'])){
  $wf = addslashes($_GET['wf']);
  $sc = "\nfind_button_click();";
}

$page_header = '<script type="text/javascript"><!--

function last100(){
var ci = document.getElementById("last_count");
var c = ci.value;
if (c>500) { alert("�� �� �������� ������ �� 500 ����."); ci.value=500; c=500; }
ajaxO.open("GET","'.$rpth.'/ajax_last_words.php?n="+c+"&a="+Math.random(),false);
ajaxO.send(null);
document.getElementById("word_links").innerHTML=ajaxO.responseText;
}

if (window.XMLHttpRequest) ajaxO=new XMLHttpRequest();
else ajaxO=new ActiveXObject("Microsoft.XMLHTTP");

function abrev_click(a){
ajaxO.open("GET","'.$rpth.'/ajax_word_list.php?i="+a+"&a="+Math.random(),false);
ajaxO.send(null);
document.getElementById("word_links").innerHTML=ajaxO.responseText;
}

function word_click(a){
ajaxO.open("GET","'.$rpth.'/ajax_word_info.php?i="+a+"&a="+Math.random(),false);
ajaxO.send(null);
document.getElementById("word_info").innerHTML=ajaxO.responseText;
}

function find_button_click(){
var w = document.getElementById("word_to_show");
var m = document.getElementById("is_main").checked;
ajaxO.open("GET","'.$rpth.'/ajax_word_find.php?i="+encodeURI(w.value)+"&m="+m+"&a="+Math.random(),false);
ajaxO.send(null);
document.getElementById("word_info").innerHTML=ajaxO.responseText;
focus_word();
}

function enterPressed(e){
if (e.keyCode==13) find_button_click();
}

function onPageLoad(){
focus_word();'.$sc.'
}

function focus_word(){
var w = document.getElementById("word_to_show");
w.focus();
}

--></script>';

// �������� ���� ���� � ��������
$fc = stored_value('bgdic_last_word_count'); //die($fc);
$changed = (($fc!=$wc) || !file_exists($dpth.'dictionary.html'));
if ($changed){ // ��� ����� �� ������ � �������� �� �������� ��� ���� dictionary.html
 
$sc = ceil(sqrt($wc));  // ���� ����� ���� �� �� ������. �� � ���� �����.
$n = 0;                 // ������� ����� �� ���� �� �������
$wa = array();          // ����� � ������� ����
$wi = array();          // ����� � �������� �� ������� ����
$wi[] = 0;              // ������� ����� ���� � � ����� 0
$lw = '';                // ���������� ����� �� ��������� ����� ����

do { // ������ �� ������ ���� ����������� �������� $sc
 // ������ �� ���������� $sc ���� ���� ���������� ��������� $lw
 // ����� ��, �� ���� ������ �� ��������� ��-�����, ��������� ������, ����� ���� ���� ���� � LIMIT $n,1
 $d = db_select_m('*', 'w_words', "`word`>'$lw' ORDER BY `word` LIMIT 0,$sc");
 $lw = $d[count($d)-1]['word'];
 $wa[] = $d[0]['word'];
 $n += $sc;
 $wi[] = $n;
} while ($n<$wc); //print_r($wa); die;

// ��������� �� ����� � ����������� �� ������� ����� �� ������� ����
$c = count($wa);
$j0 = 0; // ���� �� �������, ����� ������ �� ������� �� ��� ������� ����
$ch = ''; // ������� ����� �� ���������� ����, ��������� � �������� �����
$wp = array();  // ����� � ������� ����� �� ������� ����
for($i=1; $i<$c; $i++){
  // $l - ��-������� �� ��������� �� ��������� � �� ���������� ����
  $l = strlen($wa[$i-1]); $l1 = strlen($wa[$i]); if ($l1<$l) $l = $l1;
  // ������ �� ������� �������� ����� � ��������� � � ���������� ����
  $j = 0;
  while ( ($j<$l) && (lower($wa[$i][$j])==lower($wa[$i-1][$j])) ) $j++;
  $j++;
  if ($j0<$j) $j0=$j;
  // �������� ���� �� ���������� ����
  $w = substr($wa[$i-1],0,$j0);
  // ��� ������ ������� � �������� ����� �� ���������� ����, ������� ����� �� ���������
  if ($ch!=lower($w[0])){ $ch = lower($w[0]); $w = upper_first($w);  }
  $wp[] = $w;
  // �������� ���� �� ��������� ����
  $w = substr($wa[$i],0,$j0);
  // ��� ��������� ���� � ���������� �� ������ ����� ����, �� ��������� � ��
  if ($i == $c-1){
    if ($ch!=lower($w[0])){ $ch = lower($w[0]); $w = upper_first($w);  }
    $wp[] = $w;
  }
  $j0 = $j; 
}

$rz = '
<p>�������� ������� '.$wc.' ���� � '.$fs.' �����.</p>

<p><strong>';
foreach($wp as $i => $w){
  $rz .= '<a href="" onclick="abrev_click(\''.$wi[$i].'\');return false;">'.$w."</a> \n";
}
$rz .= '</strong></p>
';

$f = fopen($dpth.'dictionary.html','w');
fwrite($f,$rz);
fclose($f);

store_value('bgdic_last_word_count',$wc);

} // ��� ����� �� ������ �� � �������� ��������� ����� ������������ �� ���� dictionary.html
else { $rz = file_get_contents($dpth.'dictionary.html'); }

$body_adds = ' onload="onPageLoad();"';
return '<div id="find_form">
<p>����: 
<input type="text" id="word_to_show" onkeypress="enterPressed(event);" value="'.$wf.'"> 
<input type="checkbox" name="main" id="is_main"> ������� ����� 
<input type="button" value="���������" onclick="find_button_click();">
</p>
</div>

<p><input type="button" value="���������" onclick="last100();"> 
�� ���������� <input type="text" value="100" size="3" id="last_count"> �������� ����.</p>

<div id="word_info"></div>
<div id="word_links"></div>
'.$rz.'
';
}

// ����� ������� ����� �� ������ ������
function upper_first($w){
  $o = ord($w[0]);
  if (($o>223)&&($o<256)) $o = $o - 32;
  $w[0] = chr($o);
  $w = '<span style="font-size:130%">'.$w[0].'</span>'.substr($w,1,strlen($w)-1);
  return $w;
}

// ����� ����� �� $b
function lower($b){
  $o = ord($b[0]);
  if (($o>191)&&($o<224)) $o = $o + 32;
  return chr($o);
}

function customError($error_level,$error_message,$error_file,$error_line,$error_context)
  {
  echo "<b>Error in context:</b> $error_context<br>";
  } 
?>
