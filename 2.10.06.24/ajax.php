<? 
/***************************************************************************
 *                               ajax.php
 *                            -------------------
 *   begin                : Tuseday, May 1, 2007
 *   copyright            : (C) 2007 Fast Track Sites
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
	include 'includes/header.php';
	
	$actual_id = parseurl($_REQUEST['id']);
	$actual_action = parseurl($_REQUEST['action']);
	$actual_value = parseurl($_REQUEST['value']);
	$actual_type = parseurl($_REQUEST['type']);
	
	
	if ($_SESSION['user_level'] == MOD || $_SESSION['user_level'] == ADMIN) {
		//================================================
		// Main updater and get functions
		//================================================
		// Update an item in a DB table
		if ($actual_action == "updateitem") {
			$item = parseurl($_GET['item']);
			$table = parseurl($_GET['table']);
			$updateto = keeptasafe($_REQUEST['value']);
			$table = ($table == "users") ? USERSDBTABLEPREFIX . $table : DBTABLEPREFIX . $table;
			
			$sql = "UPDATE `" . $table . "` SET " . $item ." = '" . $updateto . "' WHERE id = '" . $actual_id . "'";
			$result = mysql_query($sql);
			
			echo stripslashes($updateto);	
		}
		// Get an item from a DB table
		elseif ($actual_action == "getitem") {
			$item = parseurl($_GET['item']);
			$table = parseurl($_GET['table']);
			$table = ($table == "users") ? USERSDBTABLEPREFIX . $table : DBTABLEPREFIX . $table;
			
			$sql = "SELECT " . $item . " FROM `" . $table . "` WHERE id = '" . $actual_id . "'";
			$result = mysql_query($sql);
			
			$row = mysql_fetch_array($result);
			mysql_free_result($result);
			
			echo $row[$sqlrow];
			mysql_free_result($result);			
		}	
		// Delete a row from a DB table
		elseif ($actual_action == "deleteitem") {
			$table = parseurl($_GET['table']);
			$table = ($table == "users") ? USERSDBTABLEPREFIX . $table : DBTABLEPREFIX . $table;
			
			// Kill the chosen row in the chosen DB
			$sql = "DELETE FROM `" . $table . "` WHERE id = '" . $actual_id . "'";
			$result = mysql_query($sql);
		}
		
		//================================================
		// Echo a progress spinner
		//================================================
		elseif ($actual_action == "showSpinner") {
			echo "<img src=\"themes/" . $pns_config['ftspns_theme'] . "/icons/indicator.gif\" alt=\"spinner\" />";
		}
		
		//================================================
		// Create a new contact category
		//================================================
		elseif ($actual_action == "postcat") {
			$name = keeptasafe($_POST['newcatname']);	
			
			$sql = "INSERT INTO `" . DBTABLEPREFIX . "contactcategories` (`name`) VALUES ('" . $name . "')";
			$result = mysql_query($sql);
			
			// Reprint the table
			echo printContactCategoriesTable();
		}
		
		//================================================
		// Shows a preview of our newsletter
		//================================================
		elseif ($actual_action == "showNewsletterPreview") {
			$content = keeptasafe($_GET['content']);
			
			// Create our newsletter file
			$fp=fopen("newsletters/temp/index.htm", "w");
			$result = fwrite($fp, $content);
			fclose($fp);
			
			// Print the preview iframe
			echo "
				<h3>Preview</h3>
				<iframe src=\"newsletters/temp/index.htm\" width=\"100%\" height=\"500px\"></iframe>";
		}
		
		//================================================
		// Send out our newsletter
		//================================================
		elseif ($actual_action == "sendNewsletter") {
			$newsletterSubject = keeptasafe($_POST['newsletterSubject']);
			$newsletter_id = keepsafe($_POST['newsletter_id']);
			$failCount = 0;
			$message = "";
			
			// Create our newsletter file
			if (!file_exists("newsletters/" . $newsletter_id)) mkdir("newsletters/" . $newsletter_id, 0755);
			
			$fp = fopen("newsletters/" . $newsletter_id . "/index.htm", "w");
			$sql = "SELECT * FROM `" . DBTABLEPREFIX . "newsletters` WHERE id = '" . $newsletter_id . "'";
			$result = mysql_query($sql);
					
			if ($result && mysql_num_rows($result) > 0) {
				while ($row = mysql_fetch_array($result)) {
					$message = $row['content'];
					fwrite($fp, $message);
				}
				mysql_free_result($result);
			}
			fclose($fp);
				
			// Pull the email address of contacts in the requested group
			$sql = ($actual_id == "allUsers") ? "SELECT email_address FROM `" . DBTABLEPREFIX . "contacts`" : "SELECT email_address FROM `" . DBTABLEPREFIX . "contacts` WHERE cat_id = '" . $actual_id . "'";
			$result = mysql_query($sql);
					
			if ($result && mysql_num_rows($result) > 0) {
				while ($row = mysql_fetch_array($result)) {
					// Add our view online and unsubscribe links
					$unsubscribeMessage .= "
						<br /><br />
						<a href=\"http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/newsletters/" . $newsletter_id . "/\">Having Trouble Reading this Newsletter? View it Online.</a>
						<br /><br />
						<a href=\"http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/ajax.php?action=unsubscribe&emailaddress=" . $row['email_address'] . "\">Unsubscribe</a>";
				
					$succeded = emailMessage($row['email_address'], $newsletterSubject, $message . $unsubscribeMessage);
					$failCount += ($succeded == TRUE) ? 0 : 1;
				}
				mysql_free_result($result);
			}
				
			if ($failCount == 0) { 
				$response = "
					<h2 style=\"font-color: #7dd256;\">Success</h2>
					Your newsletter was successfuly sent."; 
			}
			else { 
				$response = "
					<h2 style=\"font-color: #d25664;\">Failure</h2>
					" . $failCount . " message(s) failed to be sent"; 
			}
		
			echo $response;
		}
		else {
			// Do Nothing
		}
	}
		
	//================================================
	// Unsubscribe From Our Newsletter
	//================================================
	if ($_GET['action'] == "unsubscribe") {		
		if (isset($_GET['emailaddress'])) {
			
			$sql = "DELETE FROM `" . DBTABLEPREFIX . "contacts` WHERE email_address = '" . keeptasafe($_GET['emailaddress']) . "'";
			$result = mysql_query($sql);
			
			if ($result) { 
				$response = "
					<h2 style=\"font-color: #7dd256;\">Success</h2>
					You have been removed from our newsletter."; 
			}
			else { 
				$response = "
					<h2 style=\"font-color: #d25664;\">Failure</h2>
					You could not be removed from our newsletter. Please contact the webmaster."; 
			}
	
			echo $response;
		}		
	}
?>