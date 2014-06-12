<!-- BEGIN: newdbuser -->
<h1>Create New Database User</h1>

<div id="body">
		<div class="boxedin">
		<form method="post" action="/mysql/createdbuser">
			<table style="width: 400px; margin-left: auto; margin-right: auto;">
				<tr>
					<td><b>Database Username:</b></td>
				</tr>
				<tr>
					<td>{system_username}_<input type="text" name="dbuser"></td>
				</tr>
				<tr>
					<td><b>User Hostname:</b></td>
				</tr>
				<tr>
					<td><input type="text" name="hostname" value="%"></td>
				</tr>
				<tr>
					<td>% means the user can connect from anywhere. You can change this setting to a hostname or IP address.</td>
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


				<tr><td colspan="2"><input type="submit" value="Create User"> <a href="/mysql">Cancel</a></td></tr>
			</table>
		</form>
	
	</div>

</div>


<!-- END: newdbuser -->
