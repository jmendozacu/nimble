<!-- BEGIN: email -->
<h1>Email Management</h1>

<div id="body">
	<p>Below you can manage email services.</p>
	<p><a href="/email/newdomain">Add Domain</a></p>

	<table>
		<tr>
			<td><b>Domain</b></td>
			<td><b>Actions</b></td>
		</tr>
		<!-- BEGIN: row -->
		<tr>
			<td>{system_username}</td>
			<td>{permission_string}</td>
			<td style="width: 220px;">
				<a href="/users/su/{nimble_id}">Manage Email Accounts</a> |
				<a href="/users/delete/{nimble_id}" onclick="return confirm('Are you sure you want to delete {system_username}?')">Delete</a>
			</td>
		</tr>
		<!-- END: row -->
		<!-- BEGIN: no_domains -->
		<tr><td colspan="2">You have no domains configured for email. <a href="/email/newdomain">here</a> to add a domain to the mail services.</td></tr>
		<!-- END: no_domains -->
	</table>

</div>

<!-- END: email -->
