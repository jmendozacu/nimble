<!-- BEGIN: create_vhost -->
<h1>Add Domain</h1>

<div id="body">
		<div class="boxedin">
		<p>Create a new virtual host below.</p>
		<form method="post" action="/httpd/update">
			<table style="width: 400px; margin-left: auto; margin-right: auto;">
				<tr>
					<td><b>Domain Name:</b></td>
				</tr>
				<tr>
					<td><input type="text" name="domainname" id="domainname"></td>
				</tr>
					
				<tr>
					<td><b>Document Root:</b> (This will auto populate with a default)</td>
				</tr>
				<tr>
					<td><input type="text" style="width:98%;" name="documentroot" id="documentroot"></td>
				</tr>


				<tr><td colspan="2"><input type="submit" value="Add Domain"> <a href="/httpd">Cancel</a></td></tr>
			</table>
		</form>
	
	</div>

</div>

<script type="text/javascript">
$(document).ready(function(){
	$('#domainname').on('input', function(){
		$('#documentroot').val( '{homedir}/' + $('#domainname').val() + '/www');
	});
});
</script>

<!-- END: create_vhost -->
