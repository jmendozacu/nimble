<!-- BEGIN: mysql -->
<h1>MySQL Management</h1>

<div id="body">
	<p>After you have setup a database and a user below, <a href="/dba">click here to access phpMyAdmin</a></p>
	<p>Below is a list of databases you own.</p>
	<table>
		<tr>
			<td><b>Database Name</b></td>
			<td><b>Actions</b></td>
		</tr>
		<!-- BEGIN: dbrow -->
		<tr>
			<td>{database}</td>
			<td style="width: 220px;">
				<a href="/mysql/access/{database}">User Permissions</a> |
				<a href="/mysql/deletedb/{database}" onclick="return confirm('Are you sure you want to delete database {database}?')">Delete</a>
			</td>
		</tr>
		<!-- END: dbrow -->
		<!-- BEGIN: no_dbrows -->
		<tr><td colspan="2">You currently have no databases created.</td></tr>
		<!-- END: no_dbrows -->
	</table>
	<form method="post" action="/mysql/createdb">
	<p style="text-align: right;">
		<b>Create Database</b>: {system_username}_<input type="text" name="database">
		<input type="submit" value="Create">
	</p>
	</form>

	<p>Below is a list of database users you own.</p>
	<table>
		<tr>
			<td><b>Username</b></td>
			<td><b>Host</b></td>
			<td><b>Actions</b></td>
		</tr>
		<!-- BEGIN: dbuserrow -->
		<tr>
			<td>{dbuser}</td>
			<td>{dbhost}</td>
			<td style="width: 220px;">
				<a href="/mysql/passwd/{dbuser_url}/{dbhost_url}">Change Password</a> |
				<a href="/mysql/deleteuser/{dbuser_url}/{dbhost_url}" onclick="return confirm('Are you sure you want to delete database {dbuser}@{dbhost}?')">Delete</a>
			</td>
		</tr>
		<!-- END: dbuserrow -->
		<!-- BEGIN: no_dbuserrows -->
		<tr><td colspan="3">You currently have no database users created.</td></tr>
		<!-- END: no_dbuserrows -->
	</table>
	<p style="text-align: right;"><a href="/mysql/newdbuser">Create User</a></p>

</div>

<!-- END: mysql -->
