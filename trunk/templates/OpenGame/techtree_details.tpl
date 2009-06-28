<br>
<table align="center" width="270">
	<tr>
		<td class="c" align="center" nowrap="nowrap">
		Condiciones de construccion para <a href="infos.php?gid={id}">'{name}'</a></td>
	</tr>

{list/}
	<tr>
		<td class="c">{number}</td>
	</tr>

	{req_list/}
	<tr>
		<td class="l" align="center">
			<table width="100%" border=0>
				<tr>
					<td align="left">
						<font color="{color}">{name} ( {Level} {current} / {level} )</font>
					</td>
					<td align="right">{info}</td>
				</tr>
			</table>
		</td>
	</tr>

	{/req_list}

{/list}
</table>
