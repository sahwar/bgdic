<?php
/*
Free Bulgarian Dictionary Database
Copyright (C) 2013  Vanyo Georgiev <info@vanyog.com>

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

// �������� �� ��������� �� �����

include($idir.'lib/o_form.php');
include(dirname(dirname(__FILE__)).'/bg_spell/f_check.php');

function spell_check_text(){
global $page_header;

// ����� �� �������� ������ �� �����������
$txtf = new HTMLForm('txtch_form');
$te = new FormTextArea(translate('bgdic_web_text'),'texttch');
$txtf->add_input( $te );
$txtf->add_input( new FormInput('','','submit',translate('bgdic_web_submit')) );

// ��� ���� � �������� �����, ��� �� ���������
$rz = check_text();

$n = '';

// ��� �� � �������� ����� �� ������� ������� �� ��������� �� �����
if (!$rz) $rz = $txtf->html(); 
else {
  $rz = "<p>".translate('bgdic_web_result')."</p><div>$rz</div>";
  $n = '<p><a href="'.$_SERVER['REQUEST_URI'].'">'.translate('bgdic_web_again').'</a></p>';
}

return '<div id="bgspellchecker">
'.$rz.'
</div>
'.$n;

}

// ��������� check_text() ��������� ��������� �� ������ $_POST['texttch']
function check_text(){
// ��� �� � �������� ����� �� ����� ������ ���
if (!isset($_POST['texttch'])) return '';
// �������� � ����������� �� ����� ����, �������� �� ��������
$search = '/[�-��-�]+/is';
$GLOBALS['wrd'] = array();  // ����������� ����� �� ��������� �� � ������ ����
// ������� �� ���� ����� �� ������, � ����������� �������� ���� ������ �� �������� ��������
$m = preg_replace_callback($search, 'check_word', substr($_POST['texttch'],0,5000));
return $m;
}

function check_word($a){
global $wrd;
if (!array_key_exists($a[0],$wrd)) $wrd[$a[0]]=isCorrect($a[0]);
if ($wrd[$a[0]]) return $a[0];
else return '<span>'.$a[0].'</span>';
}

?>
