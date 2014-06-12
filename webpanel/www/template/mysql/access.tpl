<!-- BEGIN: mysqlaccess -->
<h1>MySQL Management</h1>

<div id="body">
	<p>Below is a list of databases you own.</p>
	<table>
		<tr>
			<td><b>Username</b></td>
			<td><b>Hostname</b></td>
			<td><b>Actions</b></td>
		</tr>
		<!-- BEGIN: row -->
		<tr>
			<td>{dbuser}</td>
			<td>{hostname}</td>
			<td>
				<a href="/mysql/access/{dbname}/{dbuser_url}@{hostname_url}">Remove</a>
			</td>
			
		</tr>
		<!-- END: row -->
		<!-- BEGIN: no_rows -->
		<tr><td colspan="10">No users have access to {dbname}.</td></tr>
		<!-- END: no_rows -->
	</table>
	<form method="post" action="/mysql/access/{dbname}">
	<p>
		<b>Add user</b>:
		<select name="dbuser">
			<!-- BEGIN: no_dbuser -->
			<option value="">No Users Available</option>
			<!-- END: no_dbuser -->
			<!-- BEGIN: dbuser -->
			<option value="{dbuser}@{hostname}">{dbuser}@{hostname}</option>
			<!-- END: dbuser -->
		</select>
		<input type="submit" value="Add">
	</p>
	</form>
	<p><a href="/mysql">Cancel</a></p>


</div>

<!-- END: mysqlaccess -->
