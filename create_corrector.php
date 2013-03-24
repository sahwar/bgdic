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

// ��������� ������������ ������ � ������������ ���� � ������� ������ �� 
// ��������� �� ���������� ����

$idir = dirname(dirname(dirname(__FILE__))).'/';

include($idir."lib/f_db_select_m.php");

// ��������� �� ��������� � ���� �����������
$wa = db_select_m('*', 'w_misspelled_bg_words', '`word`<>`correct` AND `correct`>"" ORDER BY `correct`');

// ������������ �� �������� �� ������

$err = array(); // ������ ������
$err1 = array(); // ���� �������� 
$err2 = array(); // ���� ����������
$err3 = array(); // ���� ���������

foreach($wa as $w){
  $d = diff( $w['correct'], $w['word'] );
  $err[] = $d;
  if (!$d[0]) {
    if (!$d[1]){ print_r($d); echo '<p>'; }
    $err1[$d[1]][]=$d;
  }
  else if (!$d[1])
          $err2[$d[0]][]=$d; 
       else 
          $err3["'".$d[0]."' -> '".$d[1]."'"][]=$d;
}

// ��������� �� ���� ����������

arsort($err1);
arsort($err2);
arsort($err3);

$cm = 1; // ��� ���� ���� ���������� ������ �� ��� �������� �� �� �� ������ � ������������

foreach($err3 as $k=>$e){
  $c=count($e);
  if ($c>$cm)
    echo "\n".'<br>$w1 = maybe_changed($w, \''.
    $e[0][0]."', '".$e[0][1]."'".'); if ($w1) $s[]=$w1; //'.$c.' '.$e[0][4];
}

echo "\n".'<br>';

foreach($err2 as $k=>$e){
  $c=count($e);
  if (($c>$cm) && ($k!=' ') && ($k!='-')){
    echo "\n".'<br>$w1 = maybe_dropped($w, \''.$k.'\'); if ($w1) $s[]=$w1; //'.$c.' '.$e[0][4];
  }
}

echo "\n".'<br>';

foreach($err1 as $k=>$e){
  $c=count($e);
  if ($c>$cm){
    echo "\n".'<br>$w1 = maybe_inserted($w, \''.$k.'\'); if ($w1) $s[]=$w1; //'.$c.' '.$e[0][4];
  }
}

function diff($w1, $w2){
// ���� ������� ���������� ���� �� ��������
// $w1 - ��������, ���������� ����
// $w2 - �������� ����
$r = array();
$n1 = strlen($w1);
$n2 = strlen($w2);
for($n=0; ($n<$n1)&&($n<$n2); $n++){
  if ($w1[$n]!=$w2[$n]) break;
}
if ($n==$n1){ // ������� � ���� �� ������
  $r[] = '';
  $r[] = substr($w2,$n,$n2-$n1);
  $r[] = $n-1;
 }
else {
  $m1=$n1-1;
  $m2=$n2-1;
  while (($m1>-1)&&($m2>-1)){
    if ($w1[$m1]!=$w2[$m2]) break;
    $m1--;
    $m2--;
  }
  if ( ($m1<$n) && ($m1>$m2) ) { // ��������� ������ �����
    $r[] = substr($w1,$m1,$n-$m1);
    $r[] = '';
    $r[] = $m1-1;
  }
  else  {
    if ( ($m2<$n) && ($m2>$m1) ){ // ���������� ������� �����
       $r[] = '';
       $r[] = substr($w2,$n,$n-$m2);
       $r[] = $m2;
    }
    else { 
       $r[] = substr($w1,$n,$m1-$n+1);
       $r[] = substr($w2,$n,$m2-$n+1);
       $r[] = $n-1;
    }
  }
}
$r[] = $w1;
$r[] = $w2;
return $r;
}

?>
