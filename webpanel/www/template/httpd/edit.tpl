<!-- BEGIN: edit_vhost -->
<h1>Edit Domain</h1>

<div id="body">
		<div class="boxedin">
		<p>Create a new virtual host below.</p>
		<form method="post" action="/httpd/update/{vhost_id}">
			<table style="width: 400px; margin-left: auto; margin-right: auto;">
				<tr>
					<td><b>Domain Name:</b></td>
				</tr>
				<tr>
					<td>{domainname}</td>
				</tr>
					
				<tr>
					<td><b>Document Root:</b></td>
				</tr>
				<tr>
					<td><input type="text" style="width:98%;" name="documentroot" value="{documentroot}"></td>
				</tr>


				<tr><td colspan="2"><input type="submit" value="Edit Domain"> <a href="/httpd">Cancel</a></td></tr>
			</table>
		</form>
	
	</div>

</div>


<!-- END: edit_vhost -->
