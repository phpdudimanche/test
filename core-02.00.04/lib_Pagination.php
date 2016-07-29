<?php
function pagination($total, $nbsurlisting, $begin, $link){
//--- limiter le nbre de pages !
	$nbsurlistingpages = ceil($total/$nbsurlisting);
	$numpage = intval($begin/$nbsurlisting)+1;
	$debut 	= $begin+1;
	$fin	= $debut -1 + $nbsurlisting;
	if ( $fin > $total )
		$fin = $total;

	?>
	<table width="80%" border=0 cellpadding="0" cellspacing="0" align="center">
	<tr>

	<?php
	if ( $nbsurlistingpages > 1){
		?>
		<td valign="baseline" width=75 >
		<?php
		if ( $begin > 0) { ?>
		<a href="<?php echo $link?>&begin=0" class="link">|< </a>
		<?php } ?>
		</td>
		<td valign="baseline" width=105 align=right>
		<?php
		if ( $begin - $nbsurlisting >= 0) {
			?><a href="<?php echo $link."&begin=".($begin-$nbsurlisting)?>" class="link"><< </a><?php
		}
		?>&nbsp;&nbsp;
		</td>
		<td valign="baseline" class='link' align=center>
		<?php
		for ($p=1;$p<=$nbsurlistingpages;$p++){
			$position = ($p-1)*$nbsurlisting;
			if ( $position == $begin ) {
				if ($p>1) echo "|";
				echo "&nbsp;".$p."&nbsp;";
			}
			else {
				if ($p>1) echo "|";
				echo "&nbsp;<a href='".$link."&begin=".$position."' class='link'>".$p."</a>&nbsp;";
			}
		}
		?>
		</td>
		<td valign="baseline" width=115>&nbsp;&nbsp;
		<?php
		if ($begin+$nbsurlisting < $total){
			?><a href="<?php echo $link."&begin=".($begin+$nbsurlisting)?>" class="link"> >></a><?php
		}
		?>
		</td>
		<td valign="baseline" width=75>
		<?php if ( $begin != (($nbsurlistingpages-1)*$nbsurlisting) ){?>
			<a href="<?php echo $link?>&begin=<?php echo(($nbsurlistingpages-1)*$nbsurlisting)?>" class="link"> >|</a>
		<?php } ?>
		</td>
		<?php
	}
	?>
	</tr>
	</table>
	<?php
}
?>
