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

// �������� �� ����������� �� ����

$exe_time = microtime(true);

$idir = dirname(dirname(dirname(__FILE__))).'/';
$ddir = $idir;

include_once($idir."conf_paths.php");
include_once($mod_apth."user/f_user.php");
include_once("f_insert_forms.php");

user();

process_data(); // ��������� �� ����������� � POST �����

// ���� �� ����������, ���������� �� �������� ����
$nw = db_select_1('*','w_misspelled_bg_words','`status`=1 ORDER BY `date_0` DESC');
if ($nw) $nw = $nw['word'];

// ���� �� ���������� �� �������� ����
$nc = db_table_field('COUNT(*)', 'w_misspelled_bg_words', '`status`=1');

$rpth = $pth.'mod/bgdic/';

$tb = ''; // ����� �� ������� �� �������� �� ����

$page_title = '����������� �� ����';

$page_header = '<script>

// ��������� �� ����� �� ajax ������
if (window.XMLHttpRequest) ajaxO=new XMLHttpRequest();
else ajaxO=new ActiveXObject("Microsoft.XMLHTTP");

// ��������� �� ��� �������� �� ������ "��������"
function fingTable(){
var s = document.getElementById("ex_word");
ajaxO.open("GET","'.$rpth.'ajax_word_table.php?w="+s.value+"&z="+Math.random(),false);
ajaxO.send(null);
var t = ajaxO.responseText;
var f = document.getElementById("table");
if (t){
  f.value = t;
  document.getElementById("new_word").focus();
}
else {
  f.value = "";
  document.getElementById("test_result").innerHTML="������ �� � ��������";
}
}

function enterPressed(e){
if (e.keyCode==13) fingTable();
}

// ��������� �� ��� �������� �� ������ "���������"
function deleteWord(){
var s = document.getElementById("ex_word");
var t = document.getElementById("table");
ajaxO.open("GET","'.$rpth.'ajax_word_delete.php?w="+s.value+"&t="+t.value+"&z="+Math.random(),false);
ajaxO.send(null);
var r = ajaxO.responseText;
if (r) alert("������ "+r+" ���� �������.");
else alert("�� ���� ������� ����, ������\n������ �� ����������\n��� ������ �� �������� ������ �� ��� ������� �� �� ������.");
}

// ��������� �� ��� �������� �� ������ "�����"
function onWordTest(){
var f = document.getElementById("new_word");
if(!f.value) onCopy();
var w = f.value;
if (w){
  var s = document.getElementById("table");
  var t = s.value;
  ajaxO.open("GET", "'.$rpth.'ajax_word_test.php?w="+w+"&t="+t+"&z="+Math.random(), false);
  ajaxO.send(null);
  document.getElementById("test_result").innerHTML=ajaxO.responseText;
}
}

function onCopy(){
var n = document.getElementById("new_word");
var s = document.getElementById("sugestion");
n.value = s.value;
}

</script>';

$page_content = '<p>������������ ����: <input type="text" id="ex_word" onkeypress="enterPressed(event);">
<input type="button" value="��������" onclick="fingTable();"> 
<input type="button" value="���������" onclick="deleteWord();"> 
<br></p>

<form action="'.$_SERVER['PHP_SELF'].'" method="POST">
<p>�������: <input type="text" name="table" id="table" value="'.$tb.'"> 
���� �������: <input type="text" name="new_table" id="new_table">
</p>

<p>���� ����: <input type="text" name="new_word" id="new_word"> 
<input type="button" value="�����" onclick="onWordTest();"> 
<input type="submit" value="�������� ��� ��������� �� ���������"> 
</p>
</form>

<p>�����������: <input type="text" id="sugestion" value="'.$nw.'"> 
<input type="button" value="��������" onclick="onCopy();"><br>
�������: '.$nc.' <a href="http://google.bg/search?q='.urlencode($nw).'" target="_blank">google</a>
</p>

<p><a href="editing.php">��������������</a></p>

<div id="test_result" style="width:600px"></div>

<div style="position:absolute; top:50px; left:650px;">
<p><strong>��������</strong>. ��� �������� �� ���� �����, ��� � ���� "������������ ����" � �������� ������������ � ������� ������� ����� �� ���� � ���� "�������" �� �������� ��������� �� ������ ������� �� ���� ����.</p>
<p><strong>���������</strong>. ��� �������� �� ������ �� ������� �� ������� ������, �������� � ���� "������������ ����" � ������ �� ������� �� ���� "�������". ��� � "�������" ��� ������ ������, �� �� ������ ����.</p>
<p><strong>����������� �� ���� � ���� �������</strong>. ������ ������ �� � �������� � ���� "���� ����", ��������� �, ����� �� �� �����, ������ �� � �������� � ���� "�������", � ������ � ������� � ���� "���� �������". ������ �� ������ "�������� ��� ��������� �� �������".</p>
<p><strong>�������� �� ���� ����</strong>. ����� �� ������ ������������ ����, ����� �������� ����� ��� ������ ���������. ������ ���� ������ �� � �������� � "���� ����", � ���������, ����� �� ������ - � "�������". ������ �� ������ "�����", �� �� �� ������� ����� ����� �� ��������. ��� ������� �� ��������� �������� �� ������ ������ "�������� ��� ��������� �� �������". � �������� ������ �� ����� ����� ������������ ���� � ����� ��������� �������.</p>
</div>

';

// ��������� �� ����������
include(__DIR__.'/build_page.php');

// ��������� �� ����������� � POST �����
function process_data(){
global $tn_prefix, $db_link, $tb;
if (count($_POST)!=3) return;
$w = addslashes($_POST['new_word']);// ��������� ����
$t = 1*$_POST['table']; $tb = $t;   // �������� ����� �� �������
$nt = 1*$_POST['new_table'];        // �������� ��� ����� �� �������
if ($nt){ // ��� � �������� ��� ����� �� ������� �� ����� ��������� �� ������
  // ������ �� ������������ ���� $w � ������� $t
  $d = db_select_1('*', 'w_words', "`word`='$w' AND `table`=$t"); //print_r($d); die;
  // ��� ��� ������ ���� �� ����� ��������� � �� $nt
  if ( $d ) update_word($d,$nt);
  return;
}
// �������� �� ���� ����
$q = "INSERT INTO `$tn_prefix"."w_words` SET `word`='$w', `table`=$t;";
mysqli_query($db_link, $q);
$i = mysqli_insert_id($db_link);
$w = db_select_1('*', 'w_words', "`ID`=$i");
insert_forms($w);
remove_sugestions($w['ID']);
}

// ���������� �� ������� �� ������ ��� ����� �� ��������� �
// $w - ����������� ����� � ������� �� ������
// $v - ����� �� ������ �������
function update_word($w,$v){
// ��� ��������� �� � �����, �� �� ����� ���� 
if ($w['table']==$v) return;
global $tn_prefix, $db_link;
// ��������� �� ������� �����
$q = "DELETE FROM `$tn_prefix"."w_word_forms` WHERE `word_id`=".$w['ID'].";";
mysqli_query($db_link, $q);
// ����� �� ��������� �� ������
$q = "UPDATE `$tn_prefix"."w_words` SET `table`=$v WHERE `ID`=".$w['ID'].";";
mysqli_query($db_link, $q);
// ���������� �� ���� �������
$w['table']=$v;
insert_forms($w);
}

// ����������� ������� �� ������ ���� ������ � ��������� � �������������� ����
// $i - ����� �� ������ ����
function remove_sugestions($i){
global $tn_prefix, $db_link;
// ������ �� ������� �� ������
$fs = db_select_m('word_form','w_word_forms',"`word_id`=$i");
// ��������� �� SQL ������
$q = "UPDATE `$tn_prefix"."w_misspelled_bg_words` SET `status`=3 WHERE ";
foreach($fs as $f) $q .= "`word`='".$f['word_form']."' OR ";
$q = substr($q,0,strlen($q)-4).';';
// ���������� �� SQL ��������
mysqli_query($db_link, $q);
};


?>
