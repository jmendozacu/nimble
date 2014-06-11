<!-- BEGIN: newzone -->
<h1>DNS Management</h1>

<div id="body">
		<div class="boxedin">
		<p>Use the form below to add a new DNS zone.</p>
		<form method="post" action="/dns/createzone">
			<table style="width: 400px; margin-left: auto; margin-right: auto;">
				<tr>
					<td><b>Zone Name/Domain Name:</b></td>
				</tr>
				<tr>
					<td><input type="text" name="domainname"></td>
				</tr>
				<tr>
					<td><b>Admin Email:</b></td>
				</tr>
				<tr>
					<td><input type="text" name="email_address"></td>
				</tr>
				<tr>
					<td>After creating the zone, you can add DNS records.</td>
				</tr>
				<tr>
					<td><b>Zone TTL:</b> (seconds)</td>
				</tr>
				<tr>
					<td><input type="text" name="zone_ttl" value="86400"></td>
				</tr>
					

				<tr><td colspan="2"><input type="submit" value="Create Zone"> <a href="/dns">Cancel</a></td></tr>
			</table>
		</form>
	
	</div>

</div>


<!-- END: newzone -->
