
<div style="width: 730px; margin: auto;">
	<div>
        <div style="clear: both; float: left; width: 220px; padding: 5px;"><b>ID:</b></div>
        <div style="float: left; width: 480px; padding: 5px;">#{$idregistro}</div>
		{foreach $_model->getCampo() as $column=>$value}
			<div style="clear: both; float: left; width: 220px; padding: 5px;"><b>{$value}:</b></div>
            <div style="float: left; width: 480px; padding: 5px;">{$dados[$column]}</div>
		{/foreach}
	</div>
</div>
