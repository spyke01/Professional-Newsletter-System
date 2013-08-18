<? 
/***************************************************************************
 *                               settings.php
 *                            -------------------
 *   begin                : Tuseday, March 14, 2006
 *   copyright            : (C) 2006 Fast Track Sites
 *   email                : sales@fasttracksites.com
 *
 *
 ***************************************************************************/

/***************************************************************************
Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:
    * Redistributions of source code must retain the above copyright
      notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright
      notice, this list of conditions and the following disclaimer in the
      documentation and/or other materials provided with the distribution.
    * Neither the name of the <organization> nor the
      names of its contributors may be used to endorse or promote products
      derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 ***************************************************************************/

if ($_SESSION['user_level'] == ADMIN) {
	
	if (isset($_POST['submit'])) {
		foreach($_POST as $name => $value) {
			if ($name != "submit"){							
				$sql = "UPDATE `" . DBTABLEPREFIX . "config` SET value = '" . $value . "' WHERE name = '" . $name . "'";
				$result = mysql_query($sql);
				//echo $sql . "<br />";
			}
		}
	}
	
	$sql = "SELECT * FROM `" . DBTABLEPREFIX . "config`";
	$result = mysql_query($sql);
	
	// This is used to let us get the actual items and not just name and value
	while ($row = mysql_fetch_array($result)) {
		$current_config[$row['name']] = $row['value'];
	}
		
	// Give our template the values
	$content = "
			<div class=\"roundedBox\">
				<form action=\"" . $menuvar['SETTINGS'] . "\" method=\"post\" target=\"_top\">
					<table class=\"contentBox\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">
						<tr><td class=\"title1\" colspan=\"2\">System Settings</td></tr>
						<tr class=\"row1\">
							<td><strong>Active: </strong></td>
							<td>
								<select name=\"ftspns_active\" class=\"settingsDropDown\">
									<option value=\"". ACTIVE . "\"" . testSelected($current_config['ftspns_active'], ACTIVE) . ">Active</option>
									<option value=\"". INACTIVE . "\"" . testSelected($current_config['ftspns_active'], INACTIVE) . ">Inactive</option>
								</select>
							</td>
						</tr>
						<tr class=\"row2\">
							<td><strong>Inactive Message: </strong></td>
							<td>
								<textarea name=\"ftspns_inactive_msg\" cols=\"40\" rows=\"10\">" . $current_config['ftspns_inactive_msg'] . "</textarea>
							</td>
						</tr>
						<tr class=\"row1\">
							<td><strong>Email Address: </strong></td>
							<td>
								<input type=\"text\" name=\"ftspns_email_address\" size=\"60\" value=\"" . $current_config['ftspns_email_address'] . "\" />
							</td>
						</tr>
					</table>
					<br />
					<center><input type=\"submit\" name=\"submit\" class=\"button\" value=\"Update Settings\" /></center>
				</form>
			</div>";

	$page->setTemplateVar('PageContent', $content);
}
else {
	$page->setTemplateVar('PageContent', "\nYou Are Not Authorized To Access This Area. Please Refrain From Trying To Do So Again.");
}
?>