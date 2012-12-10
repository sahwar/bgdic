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

// ��������� list_box($va,$n,$js) �������� html ���, ����� ������� ������.
// $va � ����� �� �������� �� �������,
// $n � ��� �� �������,
// $js - javscript, ����� �� ��������� ��� ����� �� ������� ��� � �������

function list_box($va,$n,$js){
$rz = "<select name=\"$n\" onchange=\"$js\"  multiple=\"multiple\" style=\"vertical-align:top;\" size=\"10\">\n";
if (count($va)) foreach($va as $i => $v){
 $rz .= '<option value="'.
urlencode($v).
//$v.
'">'."$v\n";
}
$rz .= '</select>';
return $rz;
}


?>
