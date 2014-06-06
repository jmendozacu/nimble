<!-- BEGIN: settings -->
<h1>Settings</h1>

<div id="body">
		<div class="boxedin">
		<p>Edit your settings below.</p>

		<!-- BEGIN: action -->
		<p>{action}</p>
		<!-- END: action -->
		<form method="post" action="/default/settings">
			<table style="width: 400px; margin-left: auto; margin-right: auto;">
				<tr><td colspan="2"><b>Email:</b></td></tr>
				<tr><td colspan="2"><input type="text" name="email_address" value="{email_address}"></td></tr>
					
				<tr>
					<td><b>Password:</b></td>
					<td><b>Retype Password:</b></td>
				</tr>
				<tr>
					<td><input type="password" name="password"></td>
					<td><input type="password" name="retype_password"></td>
				</tr>
				<tr><td colspan="2">Filling in the password field will update the password.</td></tr>

				<tr><td colspan="2"><input type="submit" value="Update Settings"> <a href="/">Cancel</a></td></tr>
			</table>
		</form>
	
	</div>
</div>

<!-- END: settings -->
