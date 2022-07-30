export default {
	install:function(Vue,options){
		var configuration={
			token_sandbox:"",
			token_production:"",
			payment_method:"paypal",
			currency:"MXN",
			total:"0.00",
			description:"Compra Paypal",
			item_list:{
				items:[],
			},
			note_to_payer:"Contactanos."
		};

		if(options.token_sandbox){
			configuration.token_sandbox=options.token_sandbox;
		}
		if(options.token_production){
			configuration.token_production=options.token_production;
		}
		/*
		 *Sintaxis de cada producto:
		 * {
				"name": "",
				"description": "",
				"quantity": "",
				"price": "",
				"sku": "1",
		   }
		 *
		 */
		var cart=decode();

		Vue.cart={
			setToken:function(t,type='production'){
				if(type=='production'){
					configuration.token_production=t;
				}
				else{
					configuration.token_sandbox=t;
				}
				console.log('Token '+type+" cambiado.");
				return true;
			},
			setTotal:function(t){
				configuration.total=t;
				return true;
			},
			getTotal:function () {
				return configuration.total;
			},
			setCurrency:function(c){
				configuration.currency=c;
				return true;
			},
			setDescription:function(d){
				configuration.description=d;
				return true;
			},
			setDetails:function(d){
				configuration.details=d;
				return true;
			},
			setNote:function(n){
				configuration.note_to_payer=n;
				return true;
			},
			setConfig:function(config){
				configuration=config;
				return true;
			},
			add:function(product){
				let pos=find(product.sku);
				if(pos==-1){
					product.currency=configuration.currency;
					cart.push(product);
				}
				else{
					cart[pos].quantity+=product.quantity;
				}

				encode();
				
				return true;
			},
			delete:function(sku){
				let pos=find(sku);
				cart.splice(pos,1);
				encode();
				return true;
			},
			getCart:function(){
				return cart;
			},
			setCart:function(c){
				cart=c;
				encode();
			},
			cleanCart:function () {
				cart=[];	
				encode();
			},
			find:function(sku){
				let pos=find(sku);
				if(pos==-1){
					return false;
				}
				else{
					return cart[pos];
				}
			},
			createPayment:function(el,f_success,f_error,t='production'){
				if(cart.length==0){
					console.log("Carrito vacio!!");
					if(window.alertify){
						alertify.notify("Carrito vacio!","warning");
					}
					return false;
				}
				if (configuration.total==0) {
					console.log("Total no se a añadido!!");
					if(window.alertify){
						alertify.notify("Total no puede ser $0!","warning");
					}
					return false;
				}
				jQuery(el).html('');
				paypal.Button.render({
		            env: t, // sandbox | production
		            // Id's de paypal
		            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
		            client: {
		                sandbox: 	configuration.token_sandbox,
		                production: configuration.token_production
		            },
		            style: {
			            label: 'buynow',
			            fundingicons: true, // optional
			            branding: true, // optional
			            size:  'medium', // small | medium | large | responsive
			            shape: 'rect',   // pill | rect
			            color: 'blue'   // gold | blue | silve | black
			        },
			        //Lenguaje
			        locale:'es_ES',
		            commit: true,
		            // payment() is called when the button is clicked
		            payment: function(data, actions) {
		                // Make a call to the REST api to create the payment
		                return actions.payment.create({
		                    payment: {
		                        transactions: [
		                            {
		                                amount: { total: configuration.total, currency: configuration.currency },
		                                description: configuration.description,
		                                item_list:{
		                                	items:cart
		                                }
		                            }
		                        ],
		                        note_to_payer: configuration.note_to_payer
		                    }
		                });
		            },

		            // onAuthorize() is called when the buyer approves the payment
		            onAuthorize: function(data, actions) {
		                // Make a call to the REST api to execute the payment
		                return actions.payment.execute().then(function() {
							alertify.notify("Pago realizado con exito.","success");
							if (typeof f_success == 'function') {
								f_success(data,actions);
							}
		                });
		            },
		            onCancel:function(){
						alertify.notify("Pago cancelado.","danger");
						if (typeof f_error == 'function') {
							f_error(data,actions);
						}
		            }

		        }, el);
			}
		}
		
		function find(sku){
			return cart.findIndex((e)=>{
				return e.sku==sku;
			});
		}
		function encode(){
			calculateTotal();
			let j=JSON.stringify(cart);
			localStorage.setItem("cart",j);
			return j;
		}
		function decode(){
			let j=[];
			if (localStorage.cart) {
				j=JSON.parse(localStorage.cart);
			}
			return j;
		}

		function calculateTotal() {
			let total=0;
			cart.forEach((v)=>{
				total+=parseFloat(v.price*v.quantity);
			});
			configuration.total=total;
		}
		calculateTotal();		
	}
}