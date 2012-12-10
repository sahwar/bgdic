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

// ��������� �� html ��� �� ����������� �� ����� �� ���� �� �������

$idir = dirname(dirname(__FILE__)).'/';

include($idir.'lib/f_db_select_1.php');

$t = 1*$_GET['t']; // ����� �� ���������
$n = 1*$_GET['n']; // ����� �� �������

$d = db_select_1('*', 'w_tables', "`table`=$t AND `ID`=$n"); 

header("Content-Type: text/html; charset=windows-1251");

echo '���������� �� <input type="text" size="2" name="old" value="'.$d['old'].'"> �����<br>
� ��������� <input type="text" size="10" name="new" value="'.$d['new'].'"><br>
�� ���������� �� ����� <input type="text" size="3" name="form_id" value="'.$d['form_id'].'">.<br>
place = <input type="text" size="3" name="place" value="'.$d['place'].'"><br><br>

<input type="button" value="���������" onclick="onChangeTableForm();">
<p><input type="button" value="�������� �� �����" onclick="onAddTableForm();">
<p><input type="button" value="��������� �� �����" onclick="onDeleteTableForm();">

';

?>
