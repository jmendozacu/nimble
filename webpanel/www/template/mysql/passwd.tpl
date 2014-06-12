<!-- BEGIN: passwd -->
<h1>Create New Database User</h1>

<div id="body">
		<div class="boxedin">
		<form method="post" action="/mysql/updatepasswd/{dbuser_url}/{hostname_url}">
			<table style="width: 400px; margin-left: auto; margin-right: auto;">
				<tr>
					<td><b>Database Username:</b></td>
				</tr>
				<tr>
					<td>{dbuser}</td>
				</tr>
				<tr>
					<td><b>User Hostname:</b></td>
				</tr>
				<tr>
					<td>{hostname}</td>
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


				<tr><td colspan="2"><input type="submit" value="Update"> <a href="/mysql">Cancel</a></td></tr>
			</table>
		</form>
	
	</div>

</div>


<!-- END: passwd -->
