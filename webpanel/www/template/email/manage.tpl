<!-- BEGIN: email -->
<h1>Email Management</h1>
<div id="body">
	<p>Below are a list of email accounts for {domainname}</p>
	<p><a href="/email/newaccount/{domain_id}">Add Email Account</a></p>

	<table>
		<tr>
			<td><b>Account</b></td>
			<td><b>Actions</b></td>
		</tr>
		<!-- BEGIN: row -->
		<tr>
			<td>{email}</td>
			<td style="width: 220px;">
				<a href="/email/editaccount/{domain_id}/{email_id}">Manage</a> |
				<a href="/email/deleteaccount/{domain_id}/{email_id}" onclick="return confirm('Are you sure you want to delete {email}?')">Delete</a>
			</td>
		</tr>
		<!-- END: row -->
		<!-- BEGIN: no_rows -->
		<tr><td colspan="2">You have no email accounts configured for {domainname}. Click <a href="/email/newaccount/{domain_id}">here</a> to create a new email account.</td></tr>
		<!-- END: no_rows -->
	</table>
	<p>Click <a href="/email">here</a> to go back to the domain listing.</p>

</div>

<!-- END: email -->
