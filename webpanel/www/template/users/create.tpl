<!-- BEGIN: create_user -->
<h1>Create New User</h1>

<div id="body">
		<div class="boxedin">
		<p>Create a new user below.</p>
		<form method="post" action="/users/update">
			<table style="width: 400px; margin-left: auto; margin-right: auto;">
				<tr>
					<td><b>Username:</b></td>
					<td><b>Email (optional):</b></td>
				</tr>
				<tr>
					<td><input type="text" maxlength="25" name="username"></td>
					<td><input type="text" name="email_address"></td>
				</tr>
					
				<tr><td colspan="2"><input type="checkbox" name="send_email"> Send login details to email address?</td></tr>
				<tr>
					<td><b>Password:</b></td>
					<td><b>Retype Password:</b></td>
				</tr>
				<tr>
					<td><input type="password" name="password"></td>
					<td><input type="password" name="retype_password"></td>
				</tr>

				<tr><td colspan="2"><b>Permissions</b></td></tr>
				<tr><td colspan="2">
					<!-- BEGIN: show_priv_own_users -->
					<input type="checkbox" name="priv_own_users"> O
					<!-- END: show_priv_own_users -->
					<!-- BEGIN: show_priv_grant_own_users -->
					<input type="checkbox" name="priv_grant_own_users"> G
					<!-- END: show_priv_grant_own_users -->
					<!-- BEGIN: show_priv_root_level -->
					<input type="checkbox" name="priv_root_level"> R
					<!-- END: show_priv_root_level -->
				</td></tr>

				<tr><td colspan="2"><input type="submit" value="Create New user"> <a href="/users">Cancel</a></td></tr>
			</table>
		</form>
	
	</div>

	<p><b>Permissions Explaination:</b></p>
	<p>O - This user can own users. This means the user is able to create their own sub-users.</p>
	<p>G - This user can grant own users. This means the user is able to grant permission to their users to create sub-sub-users.</p>
	<p>R - This means the user will be able to access all the things in nimble.</p>
</div>

<!-- END: create_user -->
