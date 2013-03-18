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

// ���������� �� html ��� �� �������� �� ����������� �� ������ ����� �� ����

function property_editor(){
global $database, $user, $password, $db_link, $body_adds, $page_header, $tb_prop_form_id, $pth, $idir;

$tb_prop_form_id = '1';

include_once($idir."conf_paths.php");
include_once($idir."lib/f_db_field_values.php");
include_once($idir."lib/f_db_select_1.php");
include_once("f_combo_box.php");
include_once("f_combo_box_i.php");
include_once('f_list_box.php');
include_once('f_form_string.php');

$rpth = $pth.'mod/bgdic/';

$rz = ''; // ����������, ����� ����� ���������

// ��� �� ��������� ����� � POST �� ����������
if (count($_POST)){ include_once('f_process_post.php'); $rz .= process_posted(); }

// ���� �� ������ �� ����� �� ��������
$pa = db_field_values('name', 'w_properties', '1');

// ���� �� ������ �� ����� �� ����
$fa = db_field_values('form', 'w_forms', '1');

// ���� �� ����������, ���������� �� �������� ����
$nw = db_select_1('*','w_misspelled_bg_words','`status`=1 ORDER BY `date_0` DESC');
if ($nw) $nw = $nw['word'];

$fs = array(); // ��������� �� �������
foreach($fa as $f){
  $fs[$f] = form_string($f,true);
}
asort($fs);
//print_r($fs); die;
$fa = array_keys($fs);
$fs = array_values($fs);

// ������ ������ �� �������
if ($tb_prop_form_id=='1') $ta = db_field_values('table', 'w_tables', $tb_prop_form_id);
else $ta = db_field_values('table', 'w_table_props', $tb_prop_form_id);

// ����� �� �������� �� �������
$tpa = db_field_values('form_id', 'w_table_props', '1');

// ��������� �� ���������� �� ���������
$ts = array(); // ��������� �� �������
foreach($tpa as $f){
  $ts[$f] = form_string($f,true);
}
asort($ts);
$tpa = array_keys($ts);
$ts  = array_values($ts);

// �������� �� onload ������ �� ����������
$body_adds = ' onload="doOnLoad();"'; 

// JavaScript ���
$page_header = '<script type="text/javascript"><!--

function cookie_by_name(n){ // �������� �� ��������� � ��� n
var l = n.length+1;
var c = document.cookie;
var p1 = c.indexOf(n+"=");
if (p1<0) return "";
var p2 = c.indexOf(";",p1+l);
if (p2<0) p2 = c.length;
return c.substring(p1+l,p2);
}

function set_cookie(n,v){ // ������ �������� v �� ��������� � ��� n
var c = document.cookie;
var a = c.split("; ");
var nc = "";
var d = false;
for(var i=0; i<a.length; i++){
  var b = a[i].split("=");
  if (b[0]==n){ nc += b[0]+"="+v; done = true; }
  else nc += b[0]+"="+b[1];
  if (i<a.length-1) nc += "; ";
}
document.cookie = nc;
}

function doOnLoad(){ // ��������� �� ��� ��������� �� ����������
var i = cookie_by_name("form_id");
if (i) {
  var s = document.forms.form_form.form_ids;
  for(var j=0; j<s.options.length; j++) if (i==s.options[j].value) { s.selectedIndex = j; break; }
}
i = cookie_by_name("table_id"); if (i) document.forms.table_form.table_ids.selectedIndex = i - 1;
//alert(cookie_by_name("table_id") - 1);
 onPropNameChanged();
 onFormChanged();
 onTableChanged();
 i = cookie_by_name("anchor");
 if (i) document.location = "#"+i;
}

// ����� �� ajax ������
if (window.XMLHttpRequest) ajaxO=new XMLHttpRequest();
else ajaxO=new ActiveXObject("Microsoft.XMLHTTP");

function onPropNameChanged(){  // ��������� �� ��� ������� �� ������ �� ������� ������ � ����� �� �������� �� ����
var f = document.forms.prop_edit_form;
var s = f.prop_name;
var i = s.selectedIndex;
f.new_name.value = s.options[i].text;
ajaxO.open("GET","'.$rpth.'ajax_values_combo_box.php?n="+s.value+"&z="+Math.random(),false);
ajaxO.send(null);
var t = ajaxO.responseText.split("|");
eval(t[0]);
document.getElementById("value_combo").innerHTML=t[1];
onPropValueChanged();
}

function onPropValueChanged(){  // ��������� �� ��� ������� �� ������ �� ������� ������ ��� ��������� �� �������� �� ����
var f = document.forms.prop_edit_form;
var fs = f.prop_value;
var i = fs.selectedIndex;
f.new_value.value = fs.options[i].text;
f.abrev.value = abrev[i];
}

function onFormChanged(){  // ��������� �� ��� ������� �� ������� ������ � ����� �� ����
var f = document.forms.form_form;
var s = f.form_ids;
ajaxO.open("GET","'.$rpth.'ajax_forms_list.php?n="+s.value+"&z="+Math.random(),false);
ajaxO.send(null);
document.getElementById("form_props").innerHTML=ajaxO.responseText;
set_cookie("form_id",s.value);
f = document.forms.table_form.form_id;
if (f) f.value = s.value;
onPropValueChanged();
}

function doPropValue(a){ // ��������� �� ��� �������� ����� �������� "��������" � "���������" �� ���������� �� ������
var f = document.forms.prop_edit_form;
f.action.value = a;
f.submit();
}

function onAddProp(){  // ��������� �� ��� �������� �� ������ "�������� �� ��������" �� ����� �������� �� ����
var f = document.forms.prop_edit_form;
var i = f.prop_name.selectedIndex;
var t = f.prop_name[i].text;
i = f.prop_value.selectedIndex;
t = t + ": "+f.prop_value[i].text;
var o = document.createElement("option");
o.innerText = t; // ������ ��� IE
o.text = t; // ������ ��� ����� ��������
f = document.forms.form_form.form_prop;
i = f.selectedIndex + 1;
//var o1 = l.options[i];
f.appendChild(o);
}

function onDelProp(){   // ��������� �� ��� �������� �� ������ "��������� �� ��������" �� ����� �������� �� ����
var f = document.forms.form_form.form_prop;
var i = f.selectedIndex;
if (i<0) alert("�������� �������� �� ���������.");
f.removeChild(f.options[i]);
}

function onDelAllProp(){   // ��������� �� ��� �������� �� ������ "��������� �� ������" �� ����� �������� �� ����
var f = document.forms.form_form.form_prop;
for(i=f.options.length-1; i>-1; i--){ f.removeChild(f.options[i]) };
}

function onFormChange(a){   // ��������� �� ��� �������� �� ������ "���������" �� ����� �������� �� ����
var f = document.forms.form_form;
f.action.value = a;
var v = "";
var pl = f.form_prop;
for(i = 0; i<pl.length; i++){
 if (v) v = v + ";";
 v = v + pl[i].text;
}
f.sended_form_props.value = v;
f.submit();
}

function onTableChanged(){ // ��������� �� ��� ��������� �� ������ �� ������� ������ � ��������� �� ����� �� ������
var f = document.forms.table_form;
var l = f.table_ids;
var i = l.selectedIndex;
ajaxO.open("GET","'.$rpth.'ajax_table_list.php?n="+l.options[i].value+"&z="+Math.random(),false);
ajaxO.send(null);
document.getElementById("table_forms").innerHTML=ajaxO.responseText;
}

function onTableFormChange(){ // ��������� �� ��� ������� �� ������ � ������� � ����� �� ���� �� ������ �������
var f = document.forms.table_form;
var s1 = f.table_forms;
var i = s1.selectedIndex;
var t = f.table_ids;
var j = t.selectedIndex;
if (i<0) return;
ajaxO.open("GET",
 "'.$rpth.'ajax_table_form.php?t="+
   t.options[j].value+"&n="+s1.options[i].value+"&z="+Math.random(),
 false
);
ajaxO.send(null);
document.getElementById("table_form_data").innerHTML=ajaxO.responseText;
}

function onAddTableForm(){ // ��������� �� ��� �������� �� ������ "�������� �� �����" � ������� � ����� �� ���� 
var f = document.forms.table_form;
f.action.value = "insert";
f.submit();
}

function onDeleteTableForm(){ // ��������� �� ��� �������� �� ������ "��������� �� �����" � ������� � ����� �� ���� 
var f = document.forms.table_form;
f.action.value = "delete";
f.submit();
}

function onChangeTableForm(){ // ��������� �� ��� �������� �� ������ "���������" �� ���������� �� ���� �� ����
var f = document.forms.table_form;
f.action.value = "update";
f.submit();
}

function onWordForm(){ // ��������� �� ��� �������� �� ������ "��������" �� ����
var f = document.forms.word_form;
var t = document.forms.table_form.table_ids;
var i = t.selectedIndex;
f.table.value = t.options[i].value;
f.submit();
}

function onNewTable(){ // ��������� �� ��� �������� �� ������ "���� �������" �� ������� �� ����� �� ����
var f = document.forms.table_form;
f.action.value = "new";
f.submit();
}

function onSimilarTable(){ // ��������� �� ��� �������� �� ������ "������� �������"
var f = document.forms.table_form;
f.action.value = "similar";
f.submit();
}

function onTablePropChanged(){ // ��������� �� ��� ����� �� ������ � ������� ��� �������� �� ������� ��� �������
var f = document.forms.table_filter;
f.submit();
}

function onWordTest(){ // ��������� �� ��� �������� �� ������ "�����"
var f = document.forms.word_form;
var w = f.words.value;
if (w){
  var s = document.forms.table_form.table_ids;
  var t = s.options[s.selectedIndex].value;
  ajaxO.open("GET", "'.$rpth.'ajax_word_test.php?w="+w+"&t="+t+"&z="+Math.random(), false);
  ajaxO.send(null);
  document.getElementById("word_test").innerHTML=ajaxO.responseText;
}
}

function showWords(){ // ��������� �� ��� �������� �� ������ "�������� ����"
var f = document.forms.table_form;
var s = f.table_ids;
var t = s.options[s.selectedIndex].value;
ajaxO.open("GET", "'.$rpth.'ajax_example_words.php?t="+t+"&z="+Math.random(), false);
ajaxO.send(null);
document.getElementById("example_words").innerHTML=ajaxO.responseText;
}
 
--></script>'; // ���� �� JavaScript ����


$rz .= '
<table><tr><td>
<!-- ������  IE 6, �� ������ �� �� �������� ������� -->

<h2>�������� �� ������:</h2>

<form method="POST" name="prop_edit_form" action="'.$_SERVER['PHP_SELF'].'"><p>
<input type="hidden" name="action" value="">
<span>'.combo_box($pa,'prop_name','onPropNameChanged();').' <input type="text" name="new_name"></span> 
<span id="value_combo"></span>  <input type="text" name="new_value"> 
<input type="text" name="abrev"><br>
<input type="button" value="��������" onclick="doPropValue(\'insert\');"> 
<input type="button" value="���������" onclick="doPropValue(\'update\');"> 
</p></form>

</td></tr><tr><td>

<h2>����� �� ��������:</h2>
<form method="POST" name="form_form" action="'.$_SERVER['PHP_SELF'].'">
<div style="overflow-y: hidden;">
<input type="hidden" name="action" value="">
<input type="hidden" name="sended_form_props" value="">
<div style="float: left; margin:5px; text-align:center;">
'.combo_box_i($fs, $fa, 'form_ids', 'onFormChanged();' ).'<br><br>
<input type="button" onclick="onFormChange(\'insert\');" value="��������"><br>
<input type="button" onclick="onFormChange(\'update\');" value="���������"> 
</div>
<div style="float: left; margin:5px;" id="form_props"></div>
<div style="float: left; margin:5px;">
<input type="button" onclick="onAddProp();" value="�������� �� ��������"><br> 
<input type="button" onclick="onDelProp();" value="��������� �� ��������"><br><br> 
<input type="button" onclick="onDelAllProp();" value="��������� �� ������">
</div> 
</div>
</form>

</td></tr><tr><td>
<a name="tables"></a>

<h2>�������:</h2>

<form method="POST" name="table_filter" action="'.$_SERVER['PHP_SELF'].'">
<p>����: <input type="text" name="table_by_word"> 
��������: '.combo_box_i($ts, $tpa, 'table_prop', 'onTablePropChanged()' ).'
<input type="submit" value="����������"> 
</p></form>

<form method="POST" name="table_form" action="'.$_SERVER['PHP_SELF'].'">
<div  style="overflow-y: hidden;">
<input type="hidden" name="action" value="">
<div style="float: left; margin:5px; text-align:center;">
������� �: '.combo_box($ta, 'table_ids', 'onTableChanged();' ).'
<p><input type="button" value="���� �������" onclick="onNewTable();"></p>
<p><input type="button" value="������� �������" onclick="onSimilarTable();"></p>
</div>
<div style="float: left; margin:5px;" id="table_forms"></div>
<div style="float: left; margin:5px;" id="table_form_data">���������� �� <input type="text" size="2" name="old" value="0"> �����<br>
� ��������� <input type="text" size="10" name="new" value=""><br>
�� ���������� �� ����� <input type="text" size="3" name="form_id" value="">.<br><br>
<input type="button" value="�������� �� �����" onclick="onAddTableForm();"></div>
<div style="float: left; margin:5px;" id="example_words"></div>
</div>
</form>

</td></tr><tr><td>
<a name="words"></a>

<h2>����:</h2>
<form method="POST" name="word_form" action="'.$_SERVER['PHP_SELF'].'">
<input type="hidden" name="table" value="">
<div  style="overflow-y: hidden;">
<div style="float: left; margin:5px;">
<input type="text" name="new_word" value="'.$nw.'"><br>
<input type="text" name="correct"><br>
<textarea style="vertical-align:top;" name="words" cols="20" rows="6"></textarea>
</div>
<div style="float: left; margin:5px;">
<a href="'.$_SERVER['PHP_SELF'].'#words">������������</a><br>
<input type="button" value="��������" onclick="onWordForm();"><br>
<input type="button" value="�����" onclick="onWordTest();">
</div>
<div style="float: left; margin:5px;" id="word_test"></div>
</div>
</form>

</td></tr></table>
';

return $rz;

}

?>
