<!-- BEGIN: dns -->
<h1>DNS Management</h1>

<div id="body">
	<form method="post" action="/dns/update/{domain_id}">
	<table>
		<tr>
			<td><b>Zone</b></td>
			<td><b>Admin Email</b></td>
			<td><b>TTL</b></td>
		</tr>
		<tr>
			<td>{domainname}</td>
			<td><input type="text" name="admin_email" size="30" value="{admin_email}"></td>
			<td><input type="text" name="zone_ttl" size="5" value="{ttl}"></td>
		</tr>
	</table>


	<p><a href="javascript:add_record();">Add Record</a></p>

	<table id="dnsentries">
		<tbody>
		<tr>
			<td><b>Record Name</b></td>
			<td><b>Type</b></td>
			<td><b>Data/Value</b></td>
			<td><b>Priority</b></td>
			<td><b>TTL</b></td>
			<td><b>Delete</b></td>
		</tr>
		<!-- BEGIN: row -->
		<tr>
			<td><input type="text" name="record[{id}][name]" value="{name}"></td>
			<td>
				<select name="record[{id}][type]">
					<option value="{type}">{type}</option>
					<option value="A">A</option>
					<option value="AAAA">AAAA</option>
					<option value="CNAME">CNAME</option>
					<option value="MX">MX</option>
					<option value="TXT">TXT</option>
					<option value="NS">NS</option>
					<option value="PTR">PTR</option>
					<option value="SRV">SRV</option>
					<option value="ALIAS">ALIAS</option>
					<option value="HINFO">HINFO</option>
					<option value="RP">RP</option>
				</select>
			</td>
			<td><input type="text" name="record[{id}][data]" size="30" value="{data}"></td>
			<td><input type="text" name="record[{id}][aux]" size="5" value="{aux}"></td>
			<td><input type="text" name="record[{id}][ttl]" size="5" value="{ttl}"></td>
			<td><input type="checkbox" name="record[{id}][delete]"></td>
		</tr>
		<!-- END: row -->
		<!-- BEGIN: no_rows -->
		<tr id="no_rows"><td colspan="6">There are no DNS records for {domainname} yet. Click <a href="javascript:add_record();">add</a> to create one.</td></tr>
		<!-- END: no_rows -->
		</tbody>
	</table>

	<p><input type="submit" value="Save Records"> <a href="/dns">Cancel</a></p>

	<p><b>Record Name</b> - The name that will describe the record. Wildcard values such as `*' or `*.sub' are supported, and this field can contain a FQDN or just a hostname. It may contain out-of-zone data if this is a glue record.</p>
	<p><b>Type</b> - This determines the record's type. If you need data type examples, please refer to the MyDNS reference page <a href="http://mydns.bboy.net/doc/html/mydns_11.html#SEC11" target="_blank">here</a>.</p>
	<p><b>Data/Value</b> - The data associated with this resource record.</p>
	<p><b>Priority</b> - This is only used for MX and SRV records to determine order. If this field is not needed, leave it as 0.</p>
	<p><b>TTL (Time To Live)</b> - This is a setting measured in seconds to determine how long DNS caching should occur for the record. Lowest setting is 300 seconds.</p>
	<p><b>Delete</b> - This will ignore a new record or delete existing entries.</p>
	</form>

	<script type="text/javascript">
		var field_num = 0;
		function add_record(){
			$('#dnsentries tr:last').after('<tr><td><input type="text" name="new_record['+field_num+'][name]"></td><td><select name="new_record['+field_num+'][type]"><option value="A">A</option><option value="AAAA">AAAA</option><option value="CNAME">CNAME</option><option value="MX">MX</option><option value="TXT">TXT</option><option value="NS">NS</option><option value="PTR">PTR</option><option value="SRV">SRV</option><option value="ALIAS">ALIAS</option><option value="HINFO">HINFO</option><option value="RP">RP</option></select></td><td><input type="text" name="new_record['+field_num+'][data]" size="30"></td><td><input type="text" name="new_record['+field_num+'][aux]" size="5" value="0"></td><td><input type="text" name="new_record['+field_num+'][ttl]" size="5" value="3600"></td><td><input type="checkbox" name="new_record['+field_num+'][delete]"></td></tr>');
			$('#no_rows').remove();
			field_num = field_num + 1;
		}
	</script>

</div>

<!-- END: dns -->
