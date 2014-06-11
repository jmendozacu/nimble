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
			<td>{domainname}</td>
			<td style="width: 220px;">
				<a href="/email/manage/{domain_id}">Manage Email Accounts</a> |
				<a href="/email/delete/{domain_id}" onclick="return confirm('Are you sure you want to delete {domainname} and all associated email and settings?')">Delete</a>
			</td>
		</tr>
		<!-- END: row -->
		<!-- BEGIN: no_rows -->
		<tr><td colspan="2">You have no domains configured for email. <a href="/email/newdomain">here</a> to add a domain to the mail services.</td></tr>
		<!-- END: no_rows -->
	</table>

</div>

<!-- END: email -->
