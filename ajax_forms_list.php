<?php
// Copyright: Vanyo Georgiev info@vanyog.com

// ����� html ��� �� ��������� �� ������ ��� ���������� �� ����.
// ������ �� ������ � $_GET['n'] �������� �� ���� `form` �� ������� `w_forms`.

$idir = dirname(dirname(__FILE__)).'/';

include($idir."lib/f_db_select_m.php");
include($idir."lib/f_db_select_1.php");
include("f_list_box.php");

$n = 1*($_GET['n']);

header("Content-Type: text/html; charset=windows-1251");

$va = db_select_m('prop_id','w_forms',"`form`='$n' ORDER BY `place`");

$ar = array();
foreach($va as $r){
  $pv = db_select_1('*', 'w_properties', "`ID`=".$r['prop_id']);
  $ar[] = $pv['name'].': '.$pv['value'];
}

echo list_box($ar, 'form_prop', '');

?>
