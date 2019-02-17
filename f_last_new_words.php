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

// ��������� �� ���������� 100 �������� �� �������� ��� �������� ����

$idir = dirname(dirname(dirname(__FILE__))).'/';
$ddir = $idir;

include_once($idir.'lib/f_db_table_field.php');
include_once($idir.'lib/f_db_select_m.php');
include_once($idir.'lib/translation.php');

function last_new_words(){
$c0 = db_table_field("COUNT(*)","w_misspelled_bg_words","status=1 OR status=3");
$ct = db_table_field("COUNT(*)","w_misspelled_bg_words","1");
$cb = db_table_field("COUNT(*)","w_misspelled_bg_words","status>0 OR correct>''");
$r0 = db_select_m("word,status","w_misspelled_bg_words",
      "(`status`=1 OR `status`=3) AND (`count`>`no`) ORDER BY `status`, date_0 DESC LIMIT 0,100");
$c = count($r0);
$cols = 4;
$c1=$c/$cols; $f=true;
$dicurl = stored_value('bgdic_url', 'http://physics-bg.org/z/');
$rz = '
<h1>���-������ 100 �� ���� '.$c0.' �������� ����</h1>
<p>���� ���� ��������� ���� � <a href="http://vanyog.com/_new/index.php?pid=8">����������� ������</a>, ��� �� �� ��������� � ������� � ��� �� �� ������� ����������� �� ������ ����, ��� ���������� � ���� �������� �� ������� �� �������� ������ � ������� � �����������. �� ������� �� ���� ����� �� ���������� '.$ct.' ����. ��������� �� '.$cb.' �� ��� �������, �� ����� ��-�������� ���� �� ������. (������ �� �� �������� '.$c0.'.) <strong>�������� �� �� �������� ��� '.($ct-$cb).' ����, �� ����� ������ �� ������ ����������</strong>. ����, ����� ��� ������� �� ������� <a href="http://vanyog.com/_new/index.php?pid=13">�� ����</a>. � ��������� ��-���� ������� ���������� 100 ���������� ����.</p>
<p>���������� ������ �������� � ������� ���� ���� �� ������ ���� �������� ����� ������ "���������" �� ���������� 100 �������� ���� �� ���������� �� <a href="'.$dicurl.'index.php?pid=2">������ �� ���������� ����</a>.</p>
<table><tr><td><p>';
foreach($r0 as $r1){
   if ($r1['status']==1){
      $rz .= '<span style="color:gray;">'.$r1['word'];
      if ($f) $rz .= '<sup>*</sup>'; $f=false;
      $rz .= "  ";
      $rz .= '</span>';
   }
   else $rz .= $r1['word'];
   if(in_edit_mode()){
     $rz .= ' <a href="http://google.bg/search?q='.urlencode($r1['word']).'">g</a>';
   }
   $rz .= " <br>";
   $c1--;
   if ($c1<=0){  $c1=$c/$cols; $rz .= '</p></td><td><p>'; } 
}
$rz .= '</p></td></tr></table>
';
if (!$f) $rz .= '<p><span style="color:gray;"><sup>*</sup> ������ � ���� �� ��������, �� ��� �� �� �������� � �������.</span></p>
';
$rz .= '<hr>';
return $rz;
}

?>