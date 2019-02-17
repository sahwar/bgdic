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

// ������� �� ajax ������ �� ����, ����� ���������� �������� ��� �������� ��������

$idir = dirname(dirname(dirname(__FILE__))).'/';
$ddir = $idir;
$file_encoding = 'windows-1251';
$site_encoding = 'windows-1251';

include($idir.'lib/f_db_select_1.php');
include($idir.'lib/f_db_select_m.php');
include($idir.'lib/f_view_table.php');
include($idir.'lib/f_encode.php');

header("Content-Type: text/html; charset=windows-1251");

$n = addslashes($_GET['n']); // ��� �� ����������
$v = addslashes($_GET['v']); // �������� �� ����������

// ������ �� �������� ���-�������� �� ����������
$p = db_select_1('*','w_properties',"`name`='$n' AND `value`='$v'");
//echo 'w_properties: '.print_r($p,true)."<br>\n";

// ������ �� �������, � ����� � ��� �������� ���-��������
$fs = db_select_m('*','w_forms',"`prop_id`=".$p['ID']);
//echo 'w_forms: '.print_r($fs,true)."<br>\n";

// ��������� �� SQL ������ �� ������ �� ���������, � ����� �� ��� ���������� �����
$q1 = '';
foreach($fs as $f){
if ($q1) $q1 .= ' OR ';
$q1 .= "`form_id`=".$f['form'];
}
//echo "$q1<br>\n";

// ������ �� ���������, � ����� ���
$t1 = db_select_m('*','w_table_props',"1 AND ($q1)");
//echo 'w_table_props: '.print_r($t1,true)."<br>\n";

$t2 = db_select_m('*','w_tables',"1 AND ($q1)");
//echo 'w_tables: '.print_r($t2,true)."<br>\n";

$ts = array();
foreach($t1 as $t) $ts[$t['table']] = '';
foreach($t2 as $t) $ts[$t['table']] = '';
$ts = array_keys($ts);

// ��������� �� SQL �������� �� ������ �� ������ �� ���������� �������
$q2 = '';
foreach($ts as $t){
if ($q2) $q2 .= ' OR ';
$q2 .= "`table`=".$t;
}

// ������ �� ������
$ws = db_select_m('*','w_words',"1 AND ($q2) GROUP BY `table` ORDER BY `table` ASC");

echo "<table>\n<th>".encode('�������</th><th>����</th><th>�����')."</th></tr>\n";

// ��������� �� ������
foreach($ws as $w){
  // ������� �� ����� �� ������ � ��������
  $ws = db_select_m('*', 'w_word_forms', "`word_id`=".$w['ID']." AND ($q1)");
  foreach($ws as $wf)
  echo '<tr><td>'.$w['table']."</td><td>".$w['word']."</td><td>".$wf['word_form']."</td></tr>\n";
}

echo "</table>\n";


?>
