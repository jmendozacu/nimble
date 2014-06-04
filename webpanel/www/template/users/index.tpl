<!-- BEGIN: users_interface -->
<h1>User Management</h1>

<div id="body">
	<div id="create_user" class="start_hidden">
		<div class="boxedin">
			<p>Create a new user below.</p>
			<form method="post" action="{site_url}/users/new">
				<table style="width: 400px; margin-left: auto; margin-right: auto;">
					<tr>
						<td><b>Username:</b></td>
						<td><b>Email (optional):</b></td>
					</tr>
					<tr>
						<td><input type="text" maxlength="25" name="username"></td>
						<td><input type="text" maxlength="25" name="email_address"></td>
					</tr>
					
					<tr><td colspan="2"><input type="checkbox" name="login_email"> Send login details to email address?</td></tr>
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
						<input type="checkbox" name="priv_own_users"> O
						<input type="checkbox" name="priv_grant_own_users"> G
						<input type="checkbox" name="priv_root_level"> R
					</td></tr>

					<tr><td colspan="2"><input type="submit" value="Create New user"></td></tr>
				</table>
			</form>
		
		</div>
		<br><br>
	</div>

	<p>You can manage users you control on this server below.</p>
	<p><a href='javascript:$("body").scrollTop(0);editorForm([{"show_element_id":"create_user"}]);'>Create New User</a></p>

	<table>
		<tr>
			<td><b>Username</b></td>
			<td><b>Permissions</b></td>
			<td><b>Actions</b></td>
		</tr>
		<!-- BEGIN: user_row -->
		<tr>
			<td>{system_username}</td>
			<td>{permission_string}</td>
			<td style="width: 220px;">
				<a href="/users/su/{user_id}">Access As</a> |
				<a href="/users/edit/{user_id}">Modify</a> |
				<a href="/users/delete/{user_id}" onclick="return confirm('Are you sure you want to delete {system_username}?')">Delete</a>
			</td>
		</tr>
		<!-- END: user_row -->
	</table>

	<p><b>Permissions Explaination:</b></p>
	<p>O - This user can own users. This means the user is able to create their own sub-users.</p>
	<p>G - This user can grant own users. This means the user is able to grant permission to their users to create sub-sub-users.</p>
	<p>R - This means the user will be able to access all the things in nimble.</p>
	<!-- root is an OGR -->
</div>

<!-- END: users_interface -->
