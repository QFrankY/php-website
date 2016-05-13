<?php
	echo validation_errors();
	echo form_open('quotes/getQuote');
	
	echo <<<HTML
		<div class="jumbotron" style="background-color:#FFFFFF;border: solid 3px #50C878;">
			<fieldset>
			
				<div class="form-group">
				<label for="garment">Apparel Type</label><br>
					<label class="radio-inline"><input type="radio" name="garment" value="Gildan G500">Gildan G500</label>
					<label class="radio-inline"><input type="radio" name="garment" value="American Apparel 2001">American Apparel 2001</label>
					<label class="radio-inline"><input type="radio" name="garment" value="Canvas 3001C">Canvas 3001C</label>
					<label class="radio-inline"><input type="radio" name="garment" value="Tultex 0202TC">Tultex 0202TC</label>
				</div>
			
				<div class="form-group">
					<label for="quantity">Quantity</label>
					<input type="input" class="form-control" name="quantity" placeholder="Enter Quantity Here"></input>
				</div>
			
				<div class="form-group">			
					<label for="numColorFront">Number of Colors on the Front</label><br>
					<label class="radio-inline"><input type="radio" name="numColorFront" value="0">0</label>
					<label class="radio-inline"><input type="radio" name="numColorFront" value="1">1</label>
					<label class="radio-inline"><input type="radio" name="numColorFront" value="2">2</label>
					<label class="radio-inline"><input type="radio" name="numColorFront" value="3">3</label>
					<label class="radio-inline"><input type="radio" name="numColorFront" value="4">4</label>
					<label class="radio-inline"><input type="radio" name="numColorFront" value="5">5</label>
					<label class="radio-inline"><input type="radio" name="numColorFront" value="6">6</label>
				</div>
			
				<div class="form-group">
					<label for="numColorBack">Number of Colors on the Back</label><br>
					<label class="radio-inline"><input type="radio" name="numColorBack" value="0">0</label>
					<label class="radio-inline"><input type="radio" name="numColorBack" value="1">1</label>
					<label class="radio-inline"><input type="radio" name="numColorBack" value="2">2</label>
					<label class="radio-inline"><input type="radio" name="numColorBack" value="3">3</label>
					<label class="radio-inline"><input type="radio" name="numColorBack" value="4">4</label>
					<label class="radio-inline"><input type="radio" name="numColorBack" value="5">5</label>
					<label class="radio-inline"><input type="radio" name="numColorBack" value="6">6</label>
				</div>
				
				<button type="submit" class="btn btn-default" values="get quote">Submit</button>	
			
			</fieldset>
        </form>
		</div>
HTML;

?>