<!-- BEGIN: create_user -->
<h1>Create New FTP User</h1>

<div id="body">
		<div class="boxedin">
		<p>Create a new FTP user below.</p>
		<form method="post" action="/ftp/update">
			<table style="width: 400px; margin-left: auto; margin-right: auto;">
				<tr>
					<td colspan="2"><b>Username:</b></td>
				</tr>
				<tr>
					<td colspan="2">{system_username}_<input type="text" maxlength="25" name="username" id="username"></td>
				</tr>
				<tr>
					<td colspan="2"><b>Home Directory:</b></td>
				</tr>
				<tr>
					<td colspan="2"><input style="width:98%;" type="text" name="homedir" id="homedir"></td>
				</tr>
					
				<tr>
					<td><b>Password:</b></td>
					<td><b>Retype Password:</b></td>
				</tr>
				<tr>
					<td><input type="password" name="password"></td>
					<td><input type="password" name="retype_password"></td>
				</tr>


				<tr><td colspan="2"><input type="submit" value="Create New user"> <a href="/ftp">Cancel</a></td></tr>
			</table>
		</form>
	
	</div>

</div>

<script type="text/javascript">
$(document).ready(function(){
	$('#username').on('input', function(){
		$('#homedir').val( '{basedir}/{system_username}_' + $('#username').val());
	});
});
</script>


<!-- END: create_user -->
