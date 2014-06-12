<!-- BEGIN: ftpusers -->
<h1>FTP User Management</h1>

<div id="body">
	<p>You can manage users you control on this server below.</p>
	<p><a href='/ftp/create'>Create New User</a></p>

	<table>
		<tr>
			<td><b>Username</b></td>
			<td><b>Home Directory</b></td>
			<td><b>Actions</b></td>
		</tr>
		<!-- BEGIN: row -->
		<tr>
			<td>{username}</td>
			<td>{homedir}</td>
			<td style="width: 220px;">
				<a href="/ftp/edit/{ftpuser_id}">Modify</a> |
				<a href="/ftp/delete/{ftpuser_id}" onclick="return confirm('Are you sure you want to delete {username}?')">Delete</a>
			</td>
		</tr>
		<!-- END: row -->
		<!-- BEGIN: no_rows -->
		<tr><td colspan="3">You currently have no FTP users. Click <a href="/ftp/create">here</a> to create one.</td></tr>
		<!-- END: no_rows -->
	</table>

</div>

<!-- END: ftpusers -->
