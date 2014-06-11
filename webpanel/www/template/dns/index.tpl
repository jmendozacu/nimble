<!-- BEGIN: dns -->
<h1>DNS Management</h1>

<div id="body">
	<p>Below you can manage DNS services.</p>
	<p><a href="/dns/newzone">Create DNS Zone</a></p>

	<table>
		<tr>
			<td><b>Zone</b></td>
			<td><b>Actions</b></td>
		</tr>
		<!-- BEGIN: row -->
		<tr>
			<td>{domainname}</td>
			<td style="width: 220px;">
				<a href="/dns/manage/{domain_id}">Manage</a> |
				<a href="/dns/delete/{domain_id}" onclick="return confirm('Are you sure you want to delete {domainname}?')">Delete</a>
			</td>
		</tr>
		<!-- END: row -->
		<!-- BEGIN: no_rows -->
		<tr><td colspan="2">You have no DNS zones configured. <a href="/dns/newzone">here</a> to add a zone.</td></tr>
		<!-- END: no_rows -->
	</table>

</div>

<!-- END: dns -->
