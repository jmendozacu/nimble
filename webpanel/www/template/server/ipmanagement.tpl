<!-- BEGIN: ipmanagement -->
<h1>IP Management</h1>

<div id="body">

	<p>You can add and remove the ability to use IP addresses for users below.</p>

	<table>
		<tr>
			<td><b>IP Address</b></td>
			<td><b>Username</b></td>
			<td><b>Actions</b></td>
		</tr>
		<tr>
			<form method="post" action="/server/ipmanagement">
				<td><input type="text" name="ipaddr"></td>
				<td>
					<select name="username" selected="">
					<!-- BEGIN: useroption -->
					<option value="{username}">{username}</option>
					<!-- END: useroption -->
					</select>
				</td>
				<td><input type="submit" value="Add IP"></td>
			</form>
		</tr>
		<!-- BEGIN: row -->
		<tr>
			<td>{ipaddr}</td>
			<td>{system_username}</td>
			<td style="width: 220px;">
				<a href="/server/ipmanagement/remove/{ipaddr}">Remove</a>
			</td>
		</tr>
		<!-- END: row -->
	</table>

</div>

<!-- END: ipmanagement -->
