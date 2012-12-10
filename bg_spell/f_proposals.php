<?php
/*
bg-online - open source bulgarian on-line spell checker
Copyright (C) 2008  Vanyo Georgiev <info@vanyog.com>

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

include("f_check.php");

function proposals($w){

$w = addslashes($w);

$s=array();

$w1 = maybe_up($w); if ($w1) $s[]=$w1;

$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //143 ������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //129 ���������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //96 ������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //66 ���������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //50 ��������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //47 �������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //34 �������������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //32 ����������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //31 ���������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //24 �������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //23 ������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //22 �����
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //18 �������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //16 �����
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //16 ������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //15 ����������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //12 ������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //10 ��������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //9 ���������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //7 �����
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //6 �����
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //6 �����
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //6 ������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //5 ��������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //5 �����
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //5 �������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //5 �����������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //5 ����
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //4 ������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //4 �����
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //4 ����
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //4 ����
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //4 �����
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //4 �����
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //4 ���������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //3 ��������
$w1 = maybe_changed($w, '�', '��'); if ($w1) $s[]=$w1; //3 �����
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //3 ���������
$w1 = maybe_changed($w, '��', '��'); if ($w1) $s[]=$w1; //3 ����
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //3 �������
$w1 = maybe_changed($w, '���', '���'); if ($w1) $s[]=$w1; //3 ���������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //3 ����������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //3 ������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //3 ���������
$w1 = maybe_changed($w, '��', '�'); if ($w1) $s[]=$w1; //3 ������������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //3 ��������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //3 ��������
$w1 = maybe_changed($w, '�', '��'); if ($w1) $s[]=$w1; //2 ������������
$w1 = maybe_changed($w, '��', '��'); if ($w1) $s[]=$w1; //2 ��������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //2 ���������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //2 ��������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //2 ���������
$w1 = maybe_changed($w, '�', '��'); if ($w1) $s[]=$w1; //2 ���������
$w1 = maybe_changed($w, '�', '��'); if ($w1) $s[]=$w1; //2 ��������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //2 �������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //2 ���������
$w1 = maybe_changed($w, '�', '��'); if ($w1) $s[]=$w1; //2 ���������
$w1 = maybe_changed($w, '��', '�'); if ($w1) $s[]=$w1; //2 �����
$w1 = maybe_changed($w, '��', '��'); if ($w1) $s[]=$w1; //2 �������
$w1 = maybe_changed($w, '��', '�'); if ($w1) $s[]=$w1; //2 ��������
$w1 = maybe_changed($w, '���', '���'); if ($w1) $s[]=$w1; //2 ����������
$w1 = maybe_changed($w, '����', '���'); if ($w1) $s[]=$w1; //2 �������������
$w1 = maybe_changed($w, '���', '���'); if ($w1) $s[]=$w1; //2 ��������
$w1 = maybe_changed($w, '���', '���'); if ($w1) $s[]=$w1; //2 �������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //2 ���������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //2 ����������
$w1 = maybe_changed($w, '��', '�'); if ($w1) $s[]=$w1; //2 ��������
$w1 = maybe_changed($w, '�', '�'); if ($w1) $s[]=$w1; //2 �����

$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //57
$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //28
$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //17
$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //15
$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //14
$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //11
$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //11
$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //9
$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //7
$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //7
$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //6
$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //3
$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //3
$w1 = maybe_dropped($w, '��'); if ($w1) $s[]=$w1; //3
$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //2
$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //2
$w1 = maybe_dropped($w, '�'); if ($w1) $s[]=$w1; //2

$w1 = maybe_inserted($w, '�'); if ($w1) $s[]=$w1; //40
$w1 = maybe_inserted($w, '�'); if ($w1) $s[]=$w1; //39
$w1 = maybe_inserted($w, '�'); if ($w1) $s[]=$w1; //21
$w1 = maybe_inserted($w, '�'); if ($w1) $s[]=$w1; //10
$w1 = maybe_inserted($w, '�'); if ($w1) $s[]=$w1; //9
$w1 = maybe_inserted($w, '�'); if ($w1) $s[]=$w1; //9
$w1 = maybe_inserted($w, '�'); if ($w1) $s[]=$w1; //7
$w1 = maybe_inserted($w, '�'); if ($w1) $s[]=$w1; //6
$w1 = maybe_inserted($w, '�'); if ($w1) $s[]=$w1; //6
$w1 = maybe_inserted($w, '�'); if ($w1) $s[]=$w1; //5
$w1 = maybe_inserted($w, '�'); if ($w1) $s[]=$w1; //5
$w1 = maybe_inserted($w, '�'); if ($w1) $s[]=$w1; //5
$w1 = maybe_inserted($w, '�'); if ($w1) $s[]=$w1; //2
$w1 = maybe_inserted($w, '�'); if ($w1) $s[]=$w1; //2
$w1 = maybe_inserted($w, '�'); if ($w1) $s[]=$w1; //2

$w1 = maybe_dropped($w, '-'); if ($w1) $s[]=$w1;
else { $w1 = maybe_2($w);  if ($w1) $s[]=$w1; }

return $s;

}

// ����� �������� �������� ���� ��� ������ $f � �������� ���������� ���� $t
function maybe_changed($w, $f, $t){
$p = 0;
$p = strpos($w,$t,$p);
while (!($p===false)){
  $p1 = $p+strlen($t);
  $r = substr($w,0,$p).$f.substr($w,$p1,strlen($w)-$p1);
  if (isCorrect($r)) return $r;
  $p = strpos($w,$t,$p+1);
//  echo "$w $f $t $p $p1 $r $p<br>";// die;
}
return '';
};

// ����� �������� �������� ����, ��� �� ��� � ��������� ������� $c
function maybe_dropped($w, $c){
for($i=0; $i<strlen($w); $i++){
  $w1 = substr($w,0,$i);
  $w2 = substr($w,$i);
  $w3 = "$w1$c$w2";
  if (isCorrect($w3)) return $w3;
}
return '';
};

// ����� �������� �������� ����, ��� � ��� � �������� ������� ������� $c
function maybe_inserted($w, $c){
for($i=0; $i<strlen($w); $i++) if ($w[$i]==$c){
  $w1 = substr($w,0,$i).substr($w,$i+1);
  if (isCorrect($w1)) return $w1;
}
return '';
};

// ������� ����, �������� ����� � �� ������ � ��������� ������ $s
function maybe_2($w){
for($i=1; $i<strlen($w); $i++){
  $w1 = substr($w,0,$i);
  $w2 = substr($w,$i);
  if (isCorrect($w1) && isCorrect($w2)) return "$w1 $w2";
}
return '';
};

// ����� ������ �������� � ��.�����, ��� ������ �� �� ���� ����
function maybe_up($w){
include_once("hlanguage.php");
$hlang = new HLanguage('bg');
if (!$w) return '';
if (array_key_exists($w[0],$hlang->uc_l)) $w = $hlang->uc_l[$w[0]].substr($w,1);
if (isCorrect($w)) return $w;
else return '';
};

?>
