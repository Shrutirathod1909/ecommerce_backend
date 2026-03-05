Future fetchCart() async {

var response = await http.get(
Uri.parse("http://192.168.1.39/ecommerce/get_cart.php?userid=$userId")
);

var data = json.decode(response.body);

if(data["success"]){

setState(() {
cartItems = data["cart"];
});

}

}