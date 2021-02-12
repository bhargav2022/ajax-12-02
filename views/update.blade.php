<!DOCTYPE html>
<html>
<head>

	<title>update data in MySQL database using Ajax</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>

<center><h1> Update Product </h1></center>
<div style="margin: auto;width: 60%;">
	<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
	</div>
	<form id="fupForm" name="form1" method="post">
    <input type="hidden" id="id" name="id" value="{{ $data[0]->id }}" >
    
		<div class="form-group">
			<label for="email">Product Name:</label>
			<input type="text" class="form-control" id="name" value="{{ $data[0]->name }}" placeholder="Name" name="name">
		</div>
		<div class="form-group">
			<label for="email">Product Image:</label>
			<input type="file"  name="name">
		</div>
		<div class="form-group">
			<label for="email">Product Price:</label>
			<input type="text" class="form-control" id="price" value="{{ $data[0]->price }}" placeholder="Price" name="price" onkeypress="return isNumber(event)">
		</div>
		<div class="form-group">
			<label for="email">Description:</label>
			<textarea class="form-control" id="desc"  placeholder="Description..." name="desc">{{ $data[0]->desc }}</textarea>
		</div>
		<div class="form-group">
			<label for="pwd">Qty:</label>
			<input type="number" class="form-control" id="qty" value="{{ $data[0]->qty }}" placeholder="Quantity" name="qty" min="0">
		</div>
		<div class="form-group" >
			<label for="pwd">Discount Type:</label>
			<select name="city" id="choice"  class="form-control">
				<!-- <option value="">Select</option> -->
				<option value="1">Percentage</option>
				<option value="2">Rs.</option>
			</select>
		</div>
		<div class="form-group">
			<label for="pwd">Discount:</label>
			<input type="text" class="form-control" id="discount" value="{{ $data[0]->discount }}" placeholder="Discount" name="discount" onkeypress="return isNumber(event)">
		</div>
		<div class="form-group">
			<label for="pwd">Total:</label>
			<input type="text" class="form-control" id="total" value="{{ $data[0]->total }}" placeholder="Total" name="total" disabled="">
		</div>
		<input type="button" name="save" class="btn btn-primary" value="Save to database" id="butupdate">
		<meta name="csrf-token" content="{{ csrf_token() }}">
	</form>
</div>
<script>
$(document).ready(function() {
	$('#butupdate').on('click', function() {
		$("#butupdate").attr("disabled", "disabled");
        var id = $('#id').val();
       //var id= $(this).data('id');
        var url = "{{URL('edit')}}";
        
        var updateproduct = url +"/"+ id;
     
		var name = $('#name').val();
		var price = $('#price').val();
		var desc = $('#desc').val();
		var qty = $('#qty').val();
		var disc = $('#discount').val();
		var total = $('#total').val();
		if(id!="" && name!="" && price!="" && qty!="" && desc!="" && disc!="" && total!=""){
            
			$.ajax({
                
				url:updateproduct,
				//url: "/store",
				type: "POST",
				data: {

					_token: '{!! csrf_token() !!}',
				   //_token: "{{ csrf_token() }}",
					name: name,
					price: price,
					desc: desc,
					qty: qty,
					discount: disc,
					total: total			
				},
				
				cache: false,
				success: function(dataResult){
					// alert(dataResult);

				
				//	var dataResult = JSON.parse(dataResult);
					if(dataResult=='1'){
						$("#butupdate").removeAttr("disabled");
						// $('#fupForm').find('input:text').val('');
						$("#success").show();
            $('#success').html('Data update successfully !');
                          //console.log(dataesult); 	
						  window.location = "{{URL('index')}}";					
					}
					else if(dataResult=='0'){
				   alert("Error occured Hello !");
					}
					
				}
			});
		}
		else{
			alert('Please fill all the field !');
		}
	});
});
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}	
$("#qty").bind('keyup mouseup', function () {
    var price = $('#price').val();
    var qty = $('#qty').val();
    var total = parseFloat(price) * parseFloat(qty);
    $('#total').val(total);
});
	
$("#price").bind('keypress mouseup', function(){
	var price = $('#price').val();
    var qty = $('#qty').val();
    var total = parseFloat(price) * parseFloat(qty);
    $('#total').val(total);
});
$("#discount").change(function(){
	var choice = $('#choice').val();
	    var price = $('#price').val();
		//var disc = $('#discount').val()// / 100;
		var qty = $('#qty').val();
	if(choice=="1")
	{
		var disc = $('#discount').val() / 100;
    	var total = parseFloat(price) * parseFloat(qty);
		var d_total = total - (total * disc);
		$("#total").val(d_total); 
	}
	//if(choice=="2")
	else
	{
		// var price = $('#price').val();
		var disc = $('#discount').val();
		// var qty = $('#qty').val();
    	var total = parseFloat(price) * parseFloat(qty);
		var d_total = total - disc;
		$("#total").val(d_total);
	}
})
</script>
</body>
</html>
