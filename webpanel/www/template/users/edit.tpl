<!-- BEGIN: edit_user -->
<h1>Modify User</h1>

<div id="body">
		<div class="boxedin">
		<p>Edit existing user below.</p>
		<form method="post" action="/users/update/{nimble_id}">
			<table style="width: 400px; margin-left: auto; margin-right: auto;">
				<tr>
					<td><b>Username:</b></td>
					<td><b>Email:</b></td>
				</tr>
				<tr>
					<td>{username}</td>
					<td><input type="text" name="email_address" value="{email_address}"></td>
				</tr>
					
				<tr>
					<td><b>Password:</b></td>
					<td><b>Retype Password:</b></td>
				</tr>
				<tr>
					<td><input type="password" name="password"></td>
					<td><input type="password" name="retype_password"></td>
				</tr>
				<tr><td colspan="2">Filling in the password field will update the password.</td></tr>

				<tr><td colspan="2"><b>Permissions</b></td></tr>
				<tr><td colspan="2">
					<!-- BEGIN: show_priv_own_users -->
					<input type="checkbox" name="priv_own_users" {priv_own_users_checked}> O
					<!-- END: show_priv_own_users -->
					<!-- BEGIN: show_priv_grant_own_users -->
					<input type="checkbox" name="priv_grant_own_users" {priv_grant_own_users_checked}> G
					<!-- END: show_priv_grant_own_users -->
					<!-- BEGIN: show_priv_root_level -->
					<input type="checkbox" name="priv_root_level" {priv_root_level_checked}> R
					<!-- END: show_priv_root_level -->

				</td></tr>

				<tr><td colspan="2"><input type="submit" value="Update {username}"> <a href="/users">Cancel</a></td></tr>
			</table>
		</form>
	
	</div>

	<p><b>Permissions Explaination:</b></p>
	<p>O - This user can own users. This means the user is able to create their own sub-users.</p>
	<p>G - This user can grant own users. This means the user is able to grant permission to their users to create sub-sub-users.</p>
	<p>R - This means the user will be able to access all the things in nimble.</p>
</div>

<!-- END: edit_user -->
