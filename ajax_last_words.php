<?php
// Copyright: Vanyo Georgiev info@vanyog.com

// �������� �� ajax ������ �� ��������� �� ���������� $_GET['n'] �������� ����

$idir = dirname(dirname(__FILE__)).'/';

include($idir.'lib/f_db_table_field.php');
include($idir.'lib/f_db_select_m.php');

$p = 1*$_GET['n']; // ���� �� ���������� ����, ����� ������ �� �� �������

$wd = db_select_m('*', 'w_words', "1 ORDER BY `ID` DESC LIMIT 0,$p"); //print_r($wd); die;

header("Content-Type: text/html; charset=windows-1251");

$cols = 5; $k = 1;
$a = count($wd)/$cols; 
echo '<div style="overflow-y: hidden;">
<div style="float: left; margin:10px;">'."\n";
foreach($wd as $i => $w){
  echo '<a href="" onclick="word_click('.$w['ID'].');return false;">'.$w['word'].'</a> '.$w['table'];
  if (($i+1)>=round($k*$a)){ $k++; echo '</div><div style="float: left; margin:10px;">'."\n"; }
  else echo "<br>\n";
}
echo "</div></div>\n"
?>
