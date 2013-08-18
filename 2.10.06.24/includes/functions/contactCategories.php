<?php 
/***************************************************************************
 *                               contactCategories.php
 *                            -------------------
 *   begin                : Saturday, Sept 24, 2005
 *   copyright            : (C) 2005 Paden Clayton - Fast Track Sites
 *   email                : sales@fasttacksites.com
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
	
	//=========================================================
	// Gets the name of a contact category from an catid
	//=========================================================
	function returnContactCategoryNameByID($catID) {
		$sql = "SELECT name FROM `" . DBTABLEPREFIX . "contactcategories` WHERE id='" . $catID . "'";
		$result = mysql_query($sql);
		
		if (mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_array($result)) {
				return $row['name'];
			}
		
			mysql_free_result($result);
		}
	}
	
	//=========================================================
	// Prints out our Contact Categories Table
	//=========================================================
	function printContactCategoriesTable() {
		global $pns_config, $menuvar;
	
		$sql = "SELECT * FROM `" . DBTABLEPREFIX . "contactcategories` ORDER BY name ASC";
		$result = mysql_query($sql);
			
		$x = 1; //reset the variable we use for our row colors	
			
		$content = "
						<table class=\"contentBox\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">
							<tr>
								<td class=\"title1\" colspan=\"2\">
									<div style=\"float: right;\">
										<form name=\"newCatForm\" id=\"newCatForm\" action=\"" . $PHP_SELF . "\" method=\"post\" onsubmit=\"ValidateForm(this); return false;\">
											<input type=\"text\" name=\"newcatname\" id=\"newcatname\" />
											<input type=\"image\" src=\"themes/" . $pns_config['ftspns_theme'] . "/icons/add.png\" />
										</form>
									</div>
									Contact Categories
								</td>
							</tr>							
							<tr class=\"title2\">
								<td><strong>Name</strong></td><td></td>
							</tr>";
		$catids = array();
		if (!$result || mysql_num_rows($result) == 0) { // No cats yet!
			$content .= "\n					<tr class=\"row1\">
												<td colspan=\"2\">There are no categories in the database.
											</tr>";	
		}
		else {	 // Print all our cats								
			while ($row = mysql_fetch_array($result)) {
				
				$content .=	"					
									<tr id=\"" . $row['id'] . "_row\" class=\"row" . $x . "\">
										<td><div id=\"" . $row['id'] . "_text\">" . $row['name'] . "</div></td>
										<td>
											<center><a style=\"cursor: pointer; cursor: hand;\" onclick=\"ajaxDeleteNotifier('" . $row['id'] . "ContactCategorySpinner', 'ajax.php?action=deleteitem&table=contactcategories&id=" . $row['id'] . "', 'contact category', '" . $row['id'] . "_row');\"><img src=\"themes/" . $pns_config['ftspns_theme'] . "/icons/delete.png\" alt=\"Delete Category\" /></a><span id=\"" . $row['id'] . "ContactCategorySpinner\" style=\"display: none;\"><img src=\"themes/" . $pns_config['ftspns_theme'] . "/icons/indicator.gif\" alt=\"spinner\" /></span></center>
										</td>
									</tr>";
				$catids[$row['id']] = $row['name'];					
				$x = ($x==2) ? 1 : 2;
			}
			mysql_free_result($result);
		}
			
		
		$content .=	"					</table>
										<script type=\"text/javascript\">";
		
		$x = 1; //reset the variable we use for our highlight colors
		foreach($catids as $key => $value) {
			$content .= ($x == 1) ? "\n							new Ajax.InPlaceEditor('" . $key . "_text', 'ajax.php?action=updateitem&table=contactcategories&item=name&id=" . $key . "', {rows:1,cols:50,highlightcolor:'#CBD5DC',highlightendcolor:'#5194B6',loadTextURL:'ajax.php?action=getitem&table=contactcategories&item=name&id=" . $key . "'});" : "\n							new Ajax.InPlaceEditor('" . $key . "_text', 'ajax.php?action=updatecat&id=" . $key . "', {rows:1,cols:50,highlightcolor:'#5194B6',highlightendcolor:'#CBD5DC',loadTextURL:'ajax.php?action=getitem&table=categories&item=name&id=" . $key . "'});";
			$x = ($x==2) ? 1 : 2;
		}
		
		$content .= "\n						</script>";	
		
		return $content;
	}	

?>