<!-- BEGIN: newaccount -->
<h1>Create New Email Account</h1>

<div id="body">
		<div class="boxedin">
		<form method="post" action="/email/updateaccount/{domain_id}">
			<table style="width: 400px; margin-left: auto; margin-right: auto;">
				<tr>
					<td><b>Email User:</b></td>
				</tr>
				<tr>
					<td><input type="text" name="user">@{domainname}</td>
				</tr>
					
				<tr>
					<td><b>Password:</b></td>
				</tr>
				<tr>
					<td><input type="password" name="password"></td>
				</tr>
				<tr>
					<td><b>Retype Password:</b></td>
				</tr>
				<tr>
					<td><input type="password" name="repassword"></td>
				</tr>


				<tr><td colspan="2"><input type="submit" value="Create"> <a href="/email/manage/{domain_id}">Cancel</a></td></tr>
			</table>
		</form>
	
	</div>

</div>


<!-- END: newaccount -->
