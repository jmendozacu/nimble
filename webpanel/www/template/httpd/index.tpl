<!-- BEGIN: httpd_interface -->
<h1>User Management</h1>

<div id="body">
	<p>Below you can manage your different websites.</p>
	<p><a href='/httpd/create'>Add Domain</a></p>

	<table>
		<tr>
			<td><b>Domain</b></td>
			<td><b>Document Root</b></td>
			<td><b>Actions</b></td>
		</tr>
		<!-- BEGIN: vhost_row -->
		<tr>
			<td>{domain}</td>
			<td>{documentroot}</td>
			<td style="width: 220px;">
				<a href="/httpd/ssl/{vhost_id}">SSL Settings</a> |
				<a href="/httpd/edit/{vhost_id}">Modify</a> |
				<a href="/httpd/delete/{vhost_id}" onclick="return confirm('Are you sure you want to delete {domain}?')">Delete</a>
			</td>
		</tr>
		<!-- END: vhost_row -->
		<!-- BEGIN: no_vhosts -->
		<tr><td colspan="3">You currently have no domains configured. Add a domain <a href="/httpd/create">here</a>.</td></tr>
		<!-- END: no_vhosts -->
	</table>

</div>

<!-- END: httpd_interface -->
