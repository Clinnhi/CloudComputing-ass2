<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

		function hideDiv(option)	
	{
		if(option=="Singaporean"){$('.cities').hide()}else{$('.cities').show()}
	}

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<div class="cities" style="display:none">New York</div>

<select id="emp_nationality" name='emp_nationality' class='form-control' onchange="hideDiv(this.value)">
<option  value="Singaporean">Singaporean</option>
<option  value="Albanian">Albanian</option>
<option  value="Algerian">Algerian</option>
<option  value="American">American</option>
</select>
</select>
</form>


</body>
</html>