<? 
/***************************************************************************
 *                               sendnewsletter.php
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

if ($_SESSION['user_level'] == ADMIN || $_SESSION['user_level'] == MOD) {
		//==================================================
		// Print out our newsletters table
		//==================================================
		$sql = "SELECT * FROM `" . DBTABLEPREFIX . "newsletters` ORDER BY id DESC";
		$result = mysql_query($sql);
		
		$x = 1; //reset the variable we use for our row colors	
		
		$content .= "
				<div class=\"roundedBox\">
					<form name=\"sendnewsletterform\" id=\"sendnewsletterform\" action=\"" . $PHP_SELF . "\" method=\"post\" onsubmit=\"return false;\">
						<table class=\"contentBox\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">
							<tr>
								<td class=\"title1\" colspan=\"2\">
									Send a Newsletter
								</td>
							</tr>
							<tr class=\"row1\">
								<td><strong>Newsletter to Send:</strong></td>
								<td>" . createDropdown("newsletters", "newsletter_id", "", "", "validate-selection") . "</td>
							</tr>
							<tr class=\"row2\">
								<td><strong>Send to Which Category:</strong></td>
								<td>" . createDropdown("contactcategoriesforsending", "id", "", "", "validate-selection") . "</td>
							</tr>
							<tr class=\"row1\">
								<td><strong>Message Subject:</strong></td>
								<td><input name=\"newsletterSubject\" id=\"newsletterSubject\" type=\"text\" class=\"required\" /></td>
							</tr>
						</table>
						<br />
						<center><input type=\"submit\" name=\"submit\" class=\"button\" value=\"Send the Selected Newsletter\" /></center>
						<script type=\"text/javascript\">
							var valid = new Validation('sendnewsletterform', {immediate : true, useTitles:false, onFormValidate : doSend});
														
							function doSend(result, theForm) {
								if (result == true) {
									// Disable our submit buttonn until we are finished
									theForm.submit.value = 'Please Wait While We Process Your Form...';
									theForm.submit.disabled = true;
									
									// Send the request and unlock our form when done 
									new Ajax.Updater('updateMe', 'ajax.php?action=showSpinner', {onComplete:function(){	new Ajax.Updater('updateMe', 'ajax.php?action=sendNewsletter', {onComplete:function(){ new Effect.Highlight('updateMe'); theForm.submit.value = 'Send the Selected Newsletter'; theForm.submit.disabled = false; }, asynchronous:true, parameters:Form.serialize(theForm), evalScripts:true}); }, asynchronous:true, evalScripts:true});
									return false;	
								}
							}
						</script>
					</form>
					<br /><br />
					<div id=\"updateMe\"></div>
				</div>";
		
	$page->setTemplateVar('PageContent', $content);
}
else {
	$page->setTemplateVar('PageContent', "\nYou Are Not Authorized To Access This Area. Please Refrain From Trying To Do So Again.");
}
?>