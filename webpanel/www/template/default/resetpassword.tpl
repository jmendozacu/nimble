<!-- BEGIN: edit_user -->
<h1>Reset Password</h1>

<div id="body">
		<div class="boxedin">
		<p>Reset your password below.</p>
		<form method="post" action="/default/resetpassword/{nimble_id}/{token}">
			<table style="width: 400px; margin-left: auto; margin-right: auto;">
				<tr>
					<td colspan="2"><b>Email:</b></td>
				</tr>
				<tr>
					<td colspan="2">{username}</td>
				</tr>
					
				<tr>
					<td><b>Password:</b></td>
					<td><b>Retype Password:</b></td>
				</tr>
				<tr>
					<td><input type="password" name="password"></td>
					<td><input type="password" name="retype_password"></td>
				</tr>

				<tr><td colspan="2"><input type="submit" value="Update Password"> <a href="/">Cancel</a></td></tr>
			</table>
		</form>
	
	</div>
</div>

<!-- END: edit_user -->
