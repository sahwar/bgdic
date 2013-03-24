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

// ������ �������� �� ��������������, ����� ������� ������� ��� ����� ��������

$idir = dirname(dirname(dirname(__FILE__))).'/';

include($idir.'conf_paths.php');
include($mod_apth.'user/f_user.php');

user();

$page_content = '<h1>�������������� �� �������</h1>
<p>
<a href="db.php">����������� �� ���������������� ����</a><br>
<a href="check_new.php">����������� �� �������� ����</a><br>
<a href="check_corrections.php">����������� �� ����������</a><br>
</p>

<p>
<a href="edit_words.php">��������, ���������, ��������� �� ��������� �� ����</a><br>
</p>
';

include($idir.'lib/build_page.php');

?>
