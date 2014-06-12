<!-- BEGIN: edit_user -->
<h1>Edit FTP User</h1>

<div id="body">
		<div class="boxedin">
		<p>Create a new FTP user below.</p>
		<form method="post" action="/ftp/update/{ftpuser_id}">
			<table style="width: 400px; margin-left: auto; margin-right: auto;">
				<tr>
					<td colspan="2"><b>Username:</b></td>
				</tr>
				<tr>
					<td colspan="2">{ftpusername}</td>
				</tr>
				<tr>
					<td colspan="2"><b>Home Directory:</b></td>
				</tr>
				<tr>
					<td colspan="2">{ftp_homedir}</td>
				</tr>
					
				<tr>
					<td><b>Password:</b></td>
					<td><b>Retype Password:</b></td>
				</tr>
				<tr>
					<td><input type="password" name="password"></td>
					<td><input type="password" name="retype_password"></td>
				</tr>


				<tr><td colspan="2"><input type="submit" value="Edit User"> <a href="/ftp">Cancel</a></td></tr>
			</table>
		</form>
	
	</div>

</div>

<!-- END: edit_user -->
