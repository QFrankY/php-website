	<div class="jumbotron" style="background-color:#FFFFFF;border: solid 3px #50C878;">
		<h3><b>Total Price Quote:</b> $<?php echo $total?></h3>
		<h3><b>Price per Item:</b> $<?php echo $perUnit?></h3><br>
		<table class="table">
		    <thead>
		      <tr>
		        <th>Cost Breakdown:</th>
		      </tr>
		    </thead>
		     <tbody>
		      <tr>
		        <td>Garment Price:</td>
		        <td align='right'>$<?php echo $garment?></td>
		      </tr>
		      <tr>
		        <td>Front Color Price:</td>
		        <td align='right'>$<?php echo $colorFront?></td>
		      </tr>
		      <tr>
		        <td>Back Color Price: </td>
		        <td align='right'>$<?php echo $colorBack?></td>
		      </tr>
		      <tr>
		        <td>Shipping:</td>
		        <td align='right'>$<?php echo $shipping?></td>
		      </tr>
		      <tr class="info">
		        <td>Subtotal:</td>
		        <td align='right'>$<?php echo $shipping+$colorBack+$colorFront+$garment?></td>
		      </tr>
		      <tr>
		      	<td></td><td></td>
		      </tr>
		      <tr>
		        <td>Compensation:</td>
		        <td align='right'>$<?php echo $compensation?></td>
		      </tr>
		      <tr>
		        <td>Mark-Up:</td>
		        <td align='right'>$<?php echo $markup?></td>
		      </tr>
		      <tr class="info">
		        <td>Total:</td>
		        <td align='right'>$<?php echo $total?></td>
		      </tr>
		  	 </tbody>
	    </table>
	
	</div>
	