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

// �������� �������� �� ajax ������, � ����� � $_GET['w'] e ��������� ����
// � ������� ������, ����� �������� ������� �� �� ������� $_GET['t'].
// ��� � $_GET['t'] ��� ������� ������, �������� ��� �������, �� �� ������� ����
// � �� ����� ������ ���, ����� �� ����� ��������� ����.


$idir = dirname(dirname(dirname(__FILE__))).'/';

include($idir."lib/f_db_select_m.php");
include($idir."lib/f_utf8_to_cp1251.php");

$w = addslashes(check_cp1251($_GET['w']));
$t = 1*$_GET['t'];

$da = db_select_m('*','w_words',"`word`='".$w."' AND `table`=$t");

header("Content-Type: text/html; charset=windows-1251");

if (count($da)==1){
  $q = "DELETE FROM `$tn_prefix"."w_words` WHERE `word`='".$w."' AND `table`=$t;";
  mysql_query($q,$db_link);
  $q1 = "DELETE FROM `$tn_prefix"."w_word_forms` WHERE `word_id`=".$da[0]['ID'].";";
  mysql_query($q1,$db_link);
  echo "$w";
}
else echo '';


?>
