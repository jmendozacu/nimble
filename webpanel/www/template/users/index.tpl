<!-- BEGIN: users_interface -->
<h1>User Management</h1>

<div id="body">
	<p>You can manage users you control on this server below.</p>
	<p><a href='/users/create'>Create New User</a></p>

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
				<a href="/users/su/{nimble_id}">Access As</a> |
				<a href="/users/edit/{nimble_id}">Modify</a> |
				<a href="/users/delete/{nimble_id}" onclick="return confirm('Are you sure you want to delete {system_username}?')">Delete</a>
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
