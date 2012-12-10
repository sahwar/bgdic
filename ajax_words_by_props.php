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

// ������� �� ajax ������ �� ����, ����� ���������� �������� ��������

$idir = dirname(dirname(__FILE__)).'/';

include($idir.'lib/f_db_select_1.php');
include($idir.'lib/f_db_select_m.php');
include($idir.'lib/f_view_table.php');

header("Content-Type: text/html; charset=windows-1251");

$n = addslashes($_GET['n']); // ��� �� ����������
$v = addslashes($_GET['v']); // �������� �� ����������

// ������ �� �������� ���-�������� �� ����������
$p = db_select_1('*','w_properties',"`name`='$n' AND `value`='$v'");

// ������ �� �������, � ����� � ��� �������� ���-��������
$fs = db_select_m('*','w_forms',"`prop_id`=".$p['ID']);

// ��������� �� SQL ������ �� ������ �� ���������, � ����� �� ��� ���������� �����
$q = '';
foreach($fs as $f){
if ($q) $q .= ' OR ';
$q .= "`form_id`=".$f['form'];
}

// ������ �� ���������
$ts = array();
$t1 = db_select_m('*','w_table_props',"1 AND ($q)");
$t2 = db_select_m('*','w_tables',"1 AND ($q)");
foreach($t1 as $t) $ts[$t['table']] = '';
foreach($t2 as $t) $ts[$t['table']] = '';
$ts = array_keys($ts);

// ��������� �� SQL �������� �� ������ �� ������ �� ���������� �������
$q = '';
foreach($ts as $t){
if ($q) $q .= ' OR ';
$q .= "`table`=".$t;
}

// ������ �� ������
$ws = db_select_m('*','w_words',"1 AND ($q) ORDER BY `ID` DESC LIMIT 0,500");

// ��������� �� ������
echo view_table($ws);

?>
